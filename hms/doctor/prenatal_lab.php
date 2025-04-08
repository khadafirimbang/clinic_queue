<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Birth Registration Form</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Toastify CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
  <div class="bg-white shadow-xl rounded-lg p-8 max-w-4xl w-full">
    <h2 class="text-2xl font-bold mb-6 text-center">Birth Registration Form</h2>
    <form id="birthForm" class="space-y-6">

      <!-- Child Information -->
      <div>
        <h3 class="text-lg font-semibold mb-2">Child Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <input type="text" name="child_first_name" placeholder="First Name" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" required />
          <input type="text" name="child_middle_name" placeholder="Middle Name" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" required />
          <input type="text" name="child_last_name" placeholder="Last Name" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" required />
          <select name="child_sex" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" required>
            <option value="" disabled selected>Sex</option>
            <option>Male</option>
            <option>Female</option>
          </select>
          <input type="date" name="child_date_of_birth" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" required />
          <input type="time" name="child_time_of_birth" placeholder="Time of Birth (e.g., 10:00 AM)" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" required />
          <input type="text" name="child_place_of_birth" placeholder="Place of Birth" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" required />
          <select name="child_birth_type" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" required>
            <option value="" disabled selected>Type of Birth</option>
            <option value="single">Single</option>
            <option value="twin">Twin</option>
            <option value="triplet">Triplet</option>
            <option value="other">Other</option>
          </select>
          <select name="child_birth_order" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" required>
            <option value="" disabled selected>Birth Order</option>
            <option value="first">First</option>
            <option value="second">Second</option>
            <option value="third">Third</option>
            <option value="other">Other</option>
          </select>
        </div>
      </div>

      <!-- Father Information -->
      <div>
        <h3 class="text-lg font-semibold mb-2">Father Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <input type="text" name="father_first_name" placeholder="First Name" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" required />
          <input type="text" name="father_middle_name" placeholder="Middle Name" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" required />
          <input type="text" name="father_last_name" placeholder="Last Name" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" required />
          <input type="text" name="father_suffix" placeholder="Suffix (e.g., Jr.)" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" />
          <input type="text" name="father_nationality" placeholder="Nationality" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" required />
          <input type="date" name="father_date_of_birth" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" required />
          <input type="text" name="father_place_of_birth" placeholder="Place of Birth" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" required />
        </div>
      </div>

      <!-- Mother Information -->
      <div>
        <h3 class="text-lg font-semibold mb-2">Mother Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <input type="text" name="mother_first_name" placeholder="First Name" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" required />
          <input type="text" name="mother_middle_name" placeholder="Middle Name" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" required />
          <input type="text" name="mother_last_name" placeholder="Last Name" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" required />
          <input type="text" name="mother_maiden_name" placeholder="Maiden Name" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" required />
          <input type="text" name="mother_nationality" placeholder="Nationality" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" required />
          <input type="date" name="mother_date_of_birth" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" required />
          <input type="text" name="mother_place_of_birth" placeholder="Place of Birth" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600" required />
        </div>
      </div>

      <!-- Additional Info -->
      <div>
        <label class="block font-medium mb-2">Were the parents married at the time of birth?</label>
        <select name="parents_married_at_birth" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600 w-full md:w-1/3" required>
          <option value="" disabled selected>Select</option>
          <option>Yes</option>
          <option>No</option>
        </select>
      </div>

      <div class="text-center mt-6">
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg w-full">Submit</button>
      </div>
    </form>
  </div>

  <!-- Toastify JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.js"></script>

  <script>
    function showToast(message, type) {
      Toastify({
        text: message,
        style: {
          background: type === 'success'
            ? "linear-gradient(to right, #00b09b, #96c93d)"
            : "linear-gradient(to right, #ff5f6d, #ffc371)"
        },
        duration: 3000,
        close: true
      }).showToast();
    }

    document.getElementById('birthForm').addEventListener('submit', async function (e) {
      e.preventDefault();
      const form = e.target;
      const formData = new FormData(form);
      const data = {};
      formData.forEach((value, key) => {
        data[key] = value;
      });

      try {
        const response = await fetch('https://civilregistrar.lgu2.com/api/integratedBirth.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(data)
        });

        const result = await response.json();

        if (response.ok) {
          showToast('Birth record submitted successfully!', 'success');
          form.reset();
        } else {
          showToast(result.message || 'Submission failed!', 'error');
        }
      } catch (error) {
        showToast('An error occurred during submission.', 'error');
        console.error(error);
      }
    });
  </script>

  
</body>
</html>
