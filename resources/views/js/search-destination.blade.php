<script>
    function searchLocation() {
        let jsonTouristDestinations = @json($touristDestinations);

        return {
            searchInput: '',
            selectedTouristDestinationIndex: '',
            touristDestinations: jsonTouristDestinations.map((item, index) => ({
                name: item.name,
                address: item.address,
                latitude: item.latitude,
                longitude: item.longitude
            })),
            selectedLatitude: '',
            selectedLongitude: '',

            get filteredTouristDestinations() {
                if (this.searchInput === '') {
                    return [];
                }

                return this.touristDestinations.filter(
                    touristDestination => touristDestination.name.toLowerCase().includes(this.searchInput.toLowerCase())
                );
            },

            reset() {
                this.searchInput = ''
            },

            selectNextList() {
                if (this.selectedTouristDestinationIndex === '') {
                    this.selectedTouristDestinationIndex = 0;
                } else {
                    this.selectedTouristDestinationIndex++;
                }

                if (this.selectedTouristDestinationIndex == this.filteredTouristDestinations.length) {
                    this.selectedTouristDestinationIndex = 0;
                }

                this.focusSelectedList();
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

                this.focusSelectedList();
            },

            focusSelectedList() {
                this.$refs.touristDestinations.children[this.selectedTouristDestinationIndex + 1].scrollIntoView({ block: 'nearest' });
                this.selectedLatitude = this.filteredTouristDestinations[this.selectedTouristDestinationIndex].latitude;
                this.selectedLongitude = this.filteredTouristDestinations[this.selectedTouristDestinationIndex].longitude;
            },

            goToMarker(latitude = this.selectedLatitude, longitude = this.selectedLongitude) {
                map.setView([latitude, longitude], 13);
                this.reset();
            }
        }
    }
</script>
