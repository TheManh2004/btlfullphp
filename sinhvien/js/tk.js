
        document.getElementById('profile-button').addEventListener('click', function() {
    var profileContainer = document.getElementById('profile-container');
    if (profileContainer.style.display === "none" || profileContainer.style.display === "") {
        profileContainer.style.display = "block";
    } else {
        profileContainer.style.display = "none";
    }
});

// Ẩn khung khi bấm ra ngoài
window.addEventListener('click', function(event) {
    var profileContainer = document.getElementById('profile-container');
    var profileButton = document.getElementById('profile-button');
    
    if (!profileContainer.contains(event.target) && !profileButton.contains(event.target)) {
        profileContainer.style.display = "none";
    }
});
   