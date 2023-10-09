const API_KEY = 'live_VYWieMaZM9uyeWnhAESDEKF6KvxyVtOYstsBmZxeJZv4MQO2n0Ea2Wdy0adkfexM';
const BASE_URL = 'https://api.thecatapi.com/v1';

function fetchCatImage() {
    fetch(`${BASE_URL}/images/search`, {
        headers: {
            'x-api-key': API_KEY
        }
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            const url = data[0].url;
            localStorage.setItem('catImageUrl', url);
            localStorage.setItem('catImageTimestamp', Date.now().toString());

            $('img[data-profile-picture]').attr('src', url);
        })
        .catch(error => {
            console.error('Error fetching cat data:', error);
        });
}

// Check if the URL exists in localStorage and if it's been there for less than 1 hour
const storedUrl = localStorage.getItem('catImageUrl');
const storedTimestamp = localStorage.getItem('catImageTimestamp');
const oneHour = 60 * 60 * 1000; // 1 hour in milliseconds

if (storedUrl && storedTimestamp && (Date.now() - parseInt(storedTimestamp) < oneHour)) {
    $('img[data-profile-picture]').attr('src', storedUrl);
} else {
    fetchCatImage();
}

