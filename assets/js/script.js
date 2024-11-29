// JavaScript functionality can go here, for example:
// - Opening links in new tabs
// - Handling modal pop-ups
// - Any dynamic updates

// Example function for opening links in new tab
document.querySelectorAll('.social-icons a').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        window.open(this.href, '_blank');
    });
});
