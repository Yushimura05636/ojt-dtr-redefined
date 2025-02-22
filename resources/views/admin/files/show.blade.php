<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Uploaded Files</h2>
    <input type="file" id="fileInput" class="mb-4 p-2 border rounded">
    <button onclick="uploadFile()" class="bg-blue-500 text-white px-4 py-2 rounded">Upload File</button>
    
    <ul id="fileList" class="mt-4 space-y-2">
        <!-- Files will be dynamically added here -->
    </ul>
</div>

<script>
    async function fetchFiles() {
        const response = await fetch("{{ route('files.index') }}");
        const data = await response.json();
        console.log(data);
        
        let fileList = document.getElementById("fileList");
        fileList.innerHTML = "";
        
        for (let file of data.files) {
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

    async function uploadFile() {
        let fileInput = document.getElementById("fileInput");
        if (!fileInput.files.length) return alert("Please select a file.");
        
        let formData = new FormData();
        formData.append("file", fileInput.files[0]);
        
        await fetch("{{ route('files.store') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        });
        
        fetchFiles();
    }

    async function deleteFile(fileId) {
        await fetch(`{{ url('files') }}/${fileId}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        });
        
        fetchFiles();
    }

    fetchFiles();
</script>