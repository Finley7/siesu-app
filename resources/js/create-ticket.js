import {Dropzone} from "dropzone";

let dropzone = new Dropzone('#ticket-attachment-dropzone', {
    success: function(file, response) {
        // Add uploaded file to the list
        addFileToList(file, response.url);
    },
    error: function(file, response) {
        alert()
    },
    complete: function(file) {
        this.removeFile(file);
    },
    sending: function(file, xhr, formData) {
        formData.append('temp_id', document.getElementById('temp-ticket-id').value); // Add additional data here
    },
    previewTemplate: `
        <div class="dz-preview dz-file-preview">
          <div class="dz-details">
            <div class="dz-filename"><span data-dz-name></span></div>
            <div class="dz-size" data-dz-size></div>
          </div>
          <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
          <div class="dz-success-mark"><span>✔</span></div>
          <div class="dz-error-mark"><span>✘</span></div>
          <div class="dz-error-message"><span data-dz-errormessage></span></div>
        </div>
    `
});

function addFileToList(file, url) {
    var listItem = document.createElement('div');
    listItem.classList.add('file-item');

    var fileName = document.createElement('span');
    fileName.classList.add('file-name');
    fileName.textContent = file.name;

    var fileSize = document.createElement('span');
    fileSize.classList.add('file-size');
    fileSize.textContent = '(' + formatFileSize(file.size) + ')';

    listItem.appendChild(fileName);
    listItem.appendChild(fileSize);

    document.getElementById('fileList').appendChild(listItem);
}

// Function to format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}
