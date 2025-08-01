const notifications = document.querySelector(".notifications"),
    buttons = document.querySelectorAll(".buttons .btn");

// Object containing details for different types of toasts
const toastDetails = {
    timer: 5000,
    success: {
        icon: "far fa-check-circle",
        text: "Success: This is a success toast."
    },
    error: {
        icon: "fas fa-window-close",
        text: "Error: This is an error toast."
    },
    warning: {
        icon: "fas fa-exclamation-triangle",
        text: "Warning: This is a warning toast."
    },
    info: {
        icon: "fas fa-info-circle",
        text: "Info: This is an information toast."
    }
};

const removeToast = (toast) => {
    toast.classList.add("hide");
    if (toast.timeoutId) clearTimeout(toast.timeoutId); // Clearing the timeout for the toast
    setTimeout(() => toast.remove(), 500); // Removing the toast after 500ms
};

const createToast = (id, text) => {
    // Getting the icon and text for the toast based on the id passed
    const {
        icon
    } = toastDetails[id];
    const toast = document.createElement("li"); // Creating a new 'li' element for the toast
    toast.className = `toast ${id}`; // Setting the classes for the toast
    // Setting the inner HTML for the toast
    toast.innerHTML = `<div class="column">
                                <i class="${icon}"></i>
                                <span>${text}</span>
                             </div>
                             <i class="fas fa-trash-alt" onclick="removeToast(this.parentElement)"></i>`;
    notifications.appendChild(toast); // Append the toast to the notification ul
    // Setting a timeout to remove the toast after the specified duration
    toast.timeoutId = setTimeout(() => removeToast(toast), toastDetails.timer);
};

