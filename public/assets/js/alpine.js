document.addEventListener('alpine:init', () => {
    Alpine.data('openSidebar', () => ({
        isSidebarOpen: false,

        toggleSidebar() {
            this.isSidebarOpen = ! this.isSidebarOpen
        }
    }))

    Alpine.data('openTouristMap', () => ({
        isTouristMapOpen: true,

        toggleTouristMap() {
            let map = L.map('touristMap').setView([-8.13593475, 111.64019829777817], 11);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
        }
    }))
})
