<script>
    document.addEventListener('alpine:init', () => {
        let jsonTouristDestinations = @json($touristDestinations);

        Alpine.data('searchLocation', () => ({
            searchInput: '',
            modalResult: false,
            selectedTouristDestinationIndex: '',
            selecteTouristDestinationdName: '',
            touristDestinations: jsonTouristDestinations.map((item, index) => ({
                name: item.name,
                address: item.address,
                latitude: item.latitude,
                longitude: item.longitude
            })),
            selectedTouristDestinationLatitude: '',
            selectedTouristDestinationLongitude: '',

            get filteredTouristDestinations() {
                if (this.searchInput === '') {
                    return [];
                }

                return this.touristDestinations.filter(touristDestination => touristDestination.name.toLowerCase().includes(this.searchInput.toLowerCase()));
            },

            reset() {
                this.searchInput = '';
            },

            selectNextList() {
                if (this.selectedTouristDestinationIndex === '') {
                    this.selectedTouristDestinationIndex = 0;
                } else {
                    this.selectedTouristDestinationIndex++;
                }

                if (this.selectedTouristDestinationIndex === this.filteredTouristDestinations.length) {
                    this.selectedTouristDestinationIndex = 0;
                }

                if (this.searchInput != '') {
                    this.focusSelectedList();
                }
            },

            selectPreviousList() {
                if (this.selectedTouristDestinationIndex === '') {
                    this.selectedTouristDestinationIndex = this.filteredTouristDestinations.length - 1;
                } else {
                    this.selectedTouristDestinationIndex--;
                }

                if (this.selectedTouristDestinationIndex < 0) {
                    this.selectedTouristDestinationIndex = this.filteredTouristDestinations.length - 1;
                }

                if (this.searchInput != '') {
                    this.focusSelectedList();
                }
            },

            focusSelectedList() {
                const selectedDestination = this.filteredTouristDestinations[this.selectedTouristDestinationIndex];

                this.$refs.touristDestinations.children[this.selectedTouristDestinationIndex + 1].scrollIntoView({ block: 'nearest' });
                this.selectedTouristDestinationLatitude = selectedDestination.latitude;
                this.selectedTouristDestinationLongitude = selectedDestination.longitude;
                this.selectedTouristDestinationName = selectedDestination.name;
            },

            goToMarker(latitude = this.selectedTouristDestinationLatitude, longitude = this.selectedTouristDestinationLongitude, name = this.selectedTouristDestinationName) {
                this.modalResult = false;
                this.$refs.input.blur();
                this.searchInput = name;
                map.setView([latitude, longitude], 13);
            }
        }))
    });
</script>
