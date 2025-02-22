<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-gray-700 mb-4">File Manager</h2>

        <!-- File Upload Form -->
        <form id="upload-form" enctype="multipart/form-data">
            @csrf
            <div class="flex items-center space-x-4">
                <input type="file" name="file" id="file" class="border p-2 rounded w-full">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Upload
                </button>
            </div>
        </form>

        <div id="upload-message" class="text-green-500 mt-3 hidden"></div>

        <hr class="my-6">

        <!-- File List -->
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Uploaded Files</h3>
        <ul id="file-list" class="space-y-2"></ul>
    </div>

    <script>
        document.getElementById("upload-form").addEventListener("submit", async function(event) {
            event.preventDefault();

            let formData = new FormData();
            formData.append("file", document.getElementById("file").files[0]);

            const response = await fetch("{{ route('files.store') }}", {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                }
            });

            if (response.ok) {
                document.getElementById("upload-message").textContent = "File uploaded successfully!";
                document.getElementById("upload-message").classList.remove("hidden");
                loadFiles();
            }
        });

        async function loadFiles() {
            const response = await fetch("{{ route('files.index') }}");
            const files = await response.json();

            
            let fileList = document.getElementById("file-list");
            fileList.innerHTML = "";
            console.log(fileList);

            for (let i = 0; i < files.length; i++) {
    let file = files[i];

    let li = document.createElement("li");
    li.classList.add("flex", "justify-between", "items-center", "bg-gray-200", "p-2", "rounded");

    li.innerHTML = `
        <span>${file.name}</span>
        <div class="flex space-x-2">
            <a href="{{ url('files') }}/${file.id}" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                Download
            </a>
            <button onclick="deleteFile('${file.id}')" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                Delete
            </button>
        </div>
    `;

    fileList.appendChild(li);
}

        }

        async function deleteFile(fileId) {
            if (!confirm("Are you sure you want to delete this file?")) return;

            const response = await fetch("{{ url('files') }}/" + fileId, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                }
            });

            if (response.ok) {
                alert("File deleted successfully!");
                loadFiles();
            }
        }

        loadFiles(); // Load files on page load
    </script>

</body>
</html>
