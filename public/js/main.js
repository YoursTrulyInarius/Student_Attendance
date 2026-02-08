function togglePassword(id) {
    const input = document.getElementById(id);
    if (input && input.type === 'password') {
        input.type = 'text';
    } else if (input) {
        input.type = 'password';
    }
}

function validatePhone(input) {
    // Remove letters
    input.value = input.value.replace(/[^0-9]/g, '');
    
    // Max 11 digits
    if (input.value.length > 11) {
        input.value = input.value.slice(0, 11);
    }
}
