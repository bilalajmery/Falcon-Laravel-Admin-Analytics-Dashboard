function requiredValidate(formData, exceptions = []) {
    const inputNames = Array.from(formData.keys()).filter(name => !exceptions.includes(name));


    for (const fieldName of inputNames) {
        const inputElement = document.querySelector(`input[name="${fieldName}"], select[name="${fieldName}"], textarea[name="${fieldName}"]`);

        if (!inputElement) {
            console.warn(`Input element for "${fieldName}" not found.`);
            continue;
        }

        const value = inputElement.value?.trim() || '';

        if (isEmptyValue(value)) {
            const displayName = formatFieldName(fieldName);
            return {
                error: true,
                message: `${displayName} is required!`
            };
        }
    }

    return { error: false };
}

function isEmptyValue(value) {
    return value === '' ||
        value === null ||
        value === '0' ||
        value === '<div><br></div>' ||
        value === '<br>';
}

function formatFieldName(fieldName) {
    return fieldName
        .replace(/([A-Z])/g, ' $1')
        .replace(/_/g, ' ')
        .replace(/Id$/i, '')
        .replace(/\b\w/g, char => char.toUpperCase())
        .trim();
}


function handleFileUpload(event, previewId, messageId, errorId) {
    const file = event.target.files[0];
    const preview = document.getElementById(previewId);
    const message = document.getElementById(messageId);
    const error = document.getElementById(errorId);

    // Reset previous states
    preview.classList.add('d-none');
    message.classList.remove('d-none');
    error.classList.add('d-none');

    if (!file) {
        error.textContent = 'No file selected.';
        error.classList.remove('d-none');
        return;
    }

    // Validate file type
    const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!validTypes.includes(file.type)) {
        error.textContent = 'Please upload a valid image (JPEG, PNG, GIF).';
        error.classList.remove('d-none');
        return;
    }

    // Validate file size (max 5MB)
    const maxSize = 5 * 1024 * 1024; // 5MB in bytes
    if (file.size > maxSize) {
        error.textContent = 'Image size must be less than 5MB.';
        error.classList.remove('d-none');
        return;
    }

    // Display preview
    const reader = new FileReader();
    reader.onload = function (e) {
        preview.src = e.target.result;
        preview.classList.remove('d-none');
        message.classList.add('d-none');
    };
    reader.onerror = function () {
        error.textContent = 'Error reading the file.';
        error.classList.remove('d-none');
    };
    reader.readAsDataURL(file);
}

$("#trashAdmin").on('click', function () {
    const isChecked = $(this).is(':checked');
    console.log('Checkbox is now:', isChecked);

    // Optional: toggle manually (not needed in normal checkbox usage)
    if (isChecked) {
        $(this).val(1); // just to reaffirm
    } else {
        $(this).val(0);
    }
});

