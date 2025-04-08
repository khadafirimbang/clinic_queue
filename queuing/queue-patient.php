
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue Status</title>
    <link rel="stylesheet" href="queue-patient.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .waiting {
            background-color: #ffcc00;
        }
        .completed {
            background-color: #90ee90;
        }
        .consulting {
            background-color: #87CEFA;
        }
        
        /* Voice selection control styles */
        .voice-control {
            margin: 20px 0;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .voice-selector {
            margin: 10px 0;
        }
        select {
            padding: 5px;
            width: 300px;
        }
        .voice-control {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Add audio element for call sound -->
    <audio id="call-sound" src="../assets/sound/call.mp3" preload="auto"></audio>

    <h1>Queueing Status</h1>
    
    <!-- Add voice control panel -->
    <div class="voice-control">
        <h3>Voice Settings</h3>
        <div class="voice-selector">
            <label for="voice-select">Select a female voice: </label>
            <select id="voice-select"></select>
        </div>
        <button id="test-voice">Test Voice</button>
        <div id="voice-status">Loading voices...</div>
    </div>

    <div class="container">
        <h2>Queue List</h2>
        <img src="../assets/img/speaker.png" alt="Speak" width="auto" height="30px" id="speak-again">
    </div>
    <table id="queue-list">
        <thead>
            <tr>
                <th>Queue Number</th>
                <th>Name</th>
                <th>Service</th>
                <th>Room No</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <h2>Completed List</h2>
    <table id="completed-list">
        <thead>
            <tr>
                <th>Queue Number</th>
                <th>Name</th>
                <th>Service</th>
                <th>Room No</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <!-- Completed list rows will be populated here -->
        </tbody>
    </table>

    <script>
        const spokenPatients = new Set(); // Track patients whose statuses have been announced
        let previousPatientStates = {}; // Track previous states to detect changes
        const callSound = document.getElementById('call-sound');
        const voiceSelect = document.getElementById('voice-select');
        const voiceStatus = document.getElementById('voice-status');
        const testVoiceBtn = document.getElementById('test-voice');
        
        // Store the user's selected voice
        let selectedVoice = null;
        
        // List of common female voice identifiers across different systems
        const femaleVoiceIdentifiers = [
            'female', 'woman', 'girl',
            'zira', 'samantha', 'victoria', 'karen', 'moira',
            'tessa', 'veena', 'fiona', 'amelie', 'lisa', 'anna',
            'joana', 'laura', 'nora'
        ];

        // Function to check if a voice is likely female based on name/identifier
        function isFemaleVoice(voice) {
            const voiceName = voice.name.toLowerCase();
            return femaleVoiceIdentifiers.some(identifier => 
                voiceName.includes(identifier.toLowerCase()));
        }

        function populateVoiceList() {
            const voices = speechSynthesis.getVoices();
            
            // Clear existing options
            voiceSelect.innerHTML = '';
            
            // Filter for likely female voices
            const femaleVoices = voices.filter(isFemaleVoice);
            
            // If we found female voices, use those
            let voicesToShow = femaleVoices.length > 0 ? femaleVoices : voices;
            
            // Add all voices to the dropdown
            voicesToShow.forEach(voice => {
                const option = document.createElement('option');
                option.value = voice.name;
                option.textContent = `${voice.name} (${voice.lang})`;
                
                // If it's a likely female voice, mark it
                if (isFemaleVoice(voice)) {
                    option.textContent += ' - Female';
                }
                
                voiceSelect.appendChild(option);
            });
            
            // If we found female voices, update status
            if (femaleVoices.length > 0) {
                voiceStatus.textContent = `Found ${femaleVoices.length} female voices`;
                
                // Preselect the first female voice
                voiceSelect.value = femaleVoices[0].name;
                selectedVoice = femaleVoices[0];
                
                // Save to localStorage
                localStorage.setItem('selectedVoiceName', femaleVoices[0].name);
            } else {
                voiceStatus.textContent = 'No female voices detected. Please select any voice and it will be adjusted to sound more feminine.';
                
                // Preselect the first voice
                if (voices.length > 0) {
                    voiceSelect.value = voices[0].name;
                    selectedVoice = voices[0];
                    localStorage.setItem('selectedVoiceName', voices[0].name);
                }
            }
        }

        function getCurrentVoice() {
            // If we have a selected voice, use it
            if (selectedVoice) {
                return selectedVoice;
            }
            
            // Otherwise, try to find the voice selected in the dropdown
            const voices = speechSynthesis.getVoices();
            const selectedName = voiceSelect.value;
            
            if (selectedName) {
                const voice = voices.find(v => v.name === selectedName);
                if (voice) {
                    selectedVoice = voice;
                    return voice;
                }
            }
            
            // Fall back to any female voice we can find
            const femaleVoice = voices.find(isFemaleVoice);
            if (femaleVoice) {
                selectedVoice = femaleVoice;
                return femaleVoice;
            }
            
            // Last resort: first voice in the list
            if (voices.length > 0) {
                selectedVoice = voices[0];
                return voices[0];
            }
            
            return null;
        }

        function speak(text) {
            if (speechSynthesis.speaking) {
                console.log("Speech already in progress, canceling...");
                speechSynthesis.cancel();
            }

            const utterance = new SpeechSynthesisUtterance(text);
            const voice = getCurrentVoice();
            
            if (voice) {
                utterance.voice = voice;
                console.log(`Using voice: ${voice.name}`);
            } else {
                console.warn('No voice found, using default voice.');
            }

            // Make voice sound more feminine if not using a known female voice
            if (voice && !isFemaleVoice(voice)) {
                utterance.pitch = 1.5;  // Higher pitch
                utterance.rate = 0.9;   // Slightly slower rate
                console.log("Adjusting non-female voice to sound more feminine");
            } else {
                // Even for female voices, slightly adjust
                utterance.pitch = 1.1;  // Slightly higher pitch
            }
            
            utterance.onstart = () => console.log(`Speaking: ${text}`);
            utterance.onerror = (event) => console.error('Speech synthesis error:', event);
            speechSynthesis.speak(utterance);
        }

        function announcePatient(patient) {
            const firstName = patient.firstname; // Get first name
            const lastNameInitial = patient.lastname.charAt(0); // Get the first letter of the last name
            const formattedName = `${firstName} ${lastNameInitial}.`; // Format the name
            const serviceLetter = `${patient.service.charAt(0)} ${patient.service.charAt(1).toUpperCase()}`; // Get the first two letters of the service
            const formattedQueueNo = `${serviceLetter}${patient.queue_number}`; // Format queue number

            const textToSpeak = `Patient ${formattedName}. Queue number ${formattedQueueNo}. Please proceed to room ${patient.room}.`;
            console.log(`Announcing patient: ${textToSpeak}`);
            
            // Play sound effect first, then speak when it finishes
            callSound.onended = function() {
                // Speak the text three times with delays
                for (let i = 0; i < 3; i++) {
                    setTimeout(() => {
                        speak(textToSpeak);
                    }, i * 6000); // 6 seconds between each announcement
                }
            };
            
            // Start playing the sound
            callSound.currentTime = 0; // Reset to beginning
            callSound.play()
                .catch(error => {
                    console.error('Error playing sound:', error);
                    // If sound fails, still announce the patient
                    for (let i = 0; i < 3; i++) {
                        setTimeout(() => {
                            speak(textToSpeak);
                        }, i * 6000); // 6 seconds between each announcement
                    }
                });
            
            // Mark this patient as announced
            spokenPatients.add(patient.id);
        }

        function fetchPatientLists() {
            fetch('get_queue.php')
                .then(response => response.json())
                .then(data => {
                    const queueTableBody = document.querySelector('#queue-list tbody');
                    const completedTableBody = document.querySelector('#completed-list tbody');

                    queueTableBody.innerHTML = '';
                    completedTableBody.innerHTML = '';

                    console.log("Fetched patient data:", data);

                    // Process queue list
                    data.queueList.forEach(patient => {
                        const firstName = patient.firstname;
                        const lastNameInitial = patient.lastname.charAt(0); // Get the first letter of the last name
                        const formattedName = `${firstName} ${lastNameInitial}.`;
                        const serviceLetter = `${patient.service.charAt(0)}${patient.service.charAt(1).toUpperCase()}`; // Get the first two letters of the service
                        const formattedQueueNo = `${serviceLetter}${patient.queue_number}`; // Format queue number

                        const row = document.createElement('tr');
                        row.classList.add(patient.status.toLowerCase());
                        row.innerHTML = `
                            <td>${formattedQueueNo}</td>
                            <td>${formattedName}</td>
                            <td>${patient.service}</td>
                            <td>${patient.room}</td>
                            <td>${patient.status}</td>
                        `;
                        queueTableBody.appendChild(row);

                        // Check if this patient's status has changed to "Consulting"
                        const previousStatus = previousPatientStates[patient.id]?.status;
                        if (patient.status === 'Consulting' && previousStatus !== 'Consulting') {
                            announcePatient(patient);
                        }
                        
                        // Update previous state
                        previousPatientStates[patient.id] = { 
                            status: patient.status,
                            name: formattedName,
                            service: patient.service
                        };
                    });

                    // Process completed list
                    data.completedList.forEach(patient => {
                        const firstName = patient.firstname; // Get first name
                        const lastNameInitial = patient.lastname.charAt(0); // Get the first letter of the last name
                        const formattedName = `${firstName} ${lastNameInitial}.`; // Format the name
                        const serviceLetter = `${patient.service.charAt(0)}${patient.service.charAt(1).toUpperCase()}`; // Get the first two letters of the service
                        const formattedQueueNo = `${serviceLetter}${patient.queue_number}`; // Format queue number

                        const row = document.createElement('tr');
                        row.classList.add(patient.status.toLowerCase());
                        row.innerHTML = `
                            <td>${formattedQueueNo}</td>
                            <td>${formattedName}</td> <!-- Use the formatted name -->
                            <td>${patient.service}</td>
                            <td>${patient.room}</td>
                            <td>${patient.status}</td>
                        `;
                        completedTableBody.appendChild(row);
                        
                        // Update previous state for completed patients too
                        previousPatientStates[patient.id] = { 
                            status: patient.status,
                            name: patient.name,
                            service: patient.service
                        };
                    });
                })
                .catch(error => console.error('Error fetching patient lists:', error));
        }

        // Initialize voice selection related events
        function initVoiceSelection() {
            // Handle voice selection change
            voiceSelect.addEventListener('change', function() {
                const voices = speechSynthesis.getVoices();
                const selectedName = this.value;
                
                selectedVoice = voices.find(voice => voice.name === selectedName);
                
                if (selectedVoice) {
                    console.log(`Voice changed to: ${selectedVoice.name}`);
                    // Save selection to localStorage
                    localStorage.setItem('selectedVoiceName', selectedName);
                }
            });
            
            // Test voice button
            testVoiceBtn.addEventListener('click', function() {
                const testText = "This is a test of the selected voice. Is this voice female enough?";
                speak(testText);
            });
            
            // Try to load previously selected voice
            const savedVoiceName = localStorage.getItem('selectedVoiceName');
            if (savedVoiceName) {
                // We'll set this when voices are available
                console.log(`Attempting to restore saved voice: ${savedVoiceName}`);
            }
        }

        // Initialize voices and populate voice list when they're loaded
        function initVoices() {
            // If voices are already available
            if (speechSynthesis.getVoices().length > 0) {
                populateVoiceList();
                
                // Try to restore saved voice
                const savedVoiceName = localStorage.getItem('selectedVoiceName');
                if (savedVoiceName) {
                    const voices = speechSynthesis.getVoices();
                    const savedVoice = voices.find(v => v.name === savedVoiceName);
                    if (savedVoice) {
                        voiceSelect.value = savedVoiceName;
                        selectedVoice = savedVoice;
                        console.log(`Restored saved voice: ${savedVoiceName}`);
                    }
                }
            }
            
            // For when voices load later
            speechSynthesis.onvoiceschanged = function() {
                populateVoiceList();
                
                // Try to restore saved voice
                const savedVoiceName = localStorage.getItem('selectedVoiceName');
                if (savedVoiceName) {
                    const voices = speechSynthesis.getVoices();
                    const savedVoice = voices.find(v => v.name === savedVoiceName);
                    if (savedVoice) {
                        voiceSelect.value = savedVoiceName;
                        selectedVoice = savedVoice;
                        console.log(`Restored saved voice: ${savedVoiceName}`);
                    }
                }
            };
        }

        // Initialize
        initVoiceSelection();
        initVoices();

        // Fetch patient lists immediately and every 5 seconds
        fetchPatientLists();
        setInterval(fetchPatientLists, 5000);

        // Speak again button functionality
        function speakAgain() {
            const queueRows = document.querySelectorAll('#queue-list tbody tr');
            let consultingPatientFound = false;

            queueRows.forEach(row => {
                const status = row.cells[4].innerText.trim(); // Trim whitespace
                if (status.toLowerCase() === 'consulting') { // Check for 'consulting' (case insensitive)
                    consultingPatientFound = true;
                    const firstName = row.cells[1].innerText; // Extract first name
                    const lastNameInitial = row.cells[1].innerText.split(' ')[1].charAt(0); // Get the first letter of the last name
                    const formattedName = `${firstName} ${lastNameInitial}.`; // Format the name
                    const room = row.cells[3].innerText;
                    const service = row.cells[2].innerText; // Get the service from the second cell
                    const queue_number = row.cells[0].innerText.match(/\d+/)[0]; // Extract only numbers | Get the queue number from the first cell
                    
                    // Get the first two letters of the service
                    const serviceLetter = `${service.charAt(0)} ${service.charAt(1)}`; 
                    const formattedQueueNo = `${serviceLetter}${queue_number}`; // Format queue number
                    const textToSpeak = `Patient ${formattedName}. Queue number ${formattedQueueNo}. Please proceed to room ${room}.`;
                    
                    // Play sound effect first
                    callSound.onended = function() {
                        // Speak the text three times with delays
                        for (let i = 0; i < 3; i++) {
                            setTimeout(() => {
                                speak(textToSpeak);
                            }, i * 6000); // 6 seconds between each announcement
                        }
                    };
                    
                    callSound.currentTime = 0; // Reset to beginning
                    callSound.play()
                        .catch(error => {
                            console.error('Error playing sound:', error);
                            // If sound fails, still announce the patient three times
                            for (let i = 0; i < 3; i++) {
                                setTimeout(() => {
                                    speak(textToSpeak);
                                }, i * 6000); // 6 seconds between each announcement
                            }
                        });
                }
            });
            
            if (!consultingPatientFound) {
                console.log("No patients with 'Consulting' status found");
            }
        }

        // Event listener for the "Speak Again" button
        document.getElementById('speak-again').addEventListener('click', speakAgain);

        // Event listener for the space key
        document.addEventListener('keydown', function(event) {
            if (event.code === 'KeyS') {
                event.preventDefault(); // Prevent scrolling when space is pressed
                speakAgain(); // Call the speakAgain function
            }
        });

    </script>

</body>
</html>
