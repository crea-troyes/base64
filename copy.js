function copyToClipboard() {
    const textarea = document.getElementById('base64text');
    textarea.select();
    textarea.setSelectionRange(0, 99999); // mobile support
    document.execCommand('copy');

    const successMsg = document.getElementById('copySuccess');
    successMsg.style.display = 'block';

    // Cache le message après 2 secondes
    setTimeout(() => {
        successMsg.style.display = 'none';
    }, 2000);
}