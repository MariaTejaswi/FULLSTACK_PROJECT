<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
    <link rel="stylesheet" href="/FULLSTACK_PROJECT/src/output.css">
    <style>
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.7s ease-in-out;
        }
        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }
        
        .contact-container {
            display: flex;
            flex-direction: column;
            gap: 24px;
            max-width: 1000px;
            width: 90%;
            margin: 0 auto;
        }
        
        @media (min-width: 768px) {
            .contact-container {
                flex-direction: row;
                align-items: flex-start;
            }
        }
        
        .map-container {
            width: 100%;
            height: 450px;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-[#3B8A9C] flex items-center justify-center min-h-screen py-12">
    <div class="absolute inset-0 bg-[url('../images/contactus.png')] bg-cover bg-center opacity-75"></div>

    <div class="contact-container relative z-10">
        <div id="formCard" class="bg-white p-8 rounded-2xl shadow-xl w-full fade-in scale-95">
            <h2 class="text-3xl font-bold mb-6 text-[#3B8A9C] text-center animate-bounce">Contact Us</h2>
            <form action="submit_contact.php" method="POST" class="space-y-5">
                <input type="text" name="name" placeholder="Your Name" required 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3B8A9C] transition-all duration-300 hover:shadow-md" />

                <input type="email" name="email" placeholder="Your Email" required 
                       class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3B8A9C] transition-all duration-300 hover:shadow-md" />

                <select name="type" required 
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3B8A9C] transition-all duration-300 hover:shadow-md">
                    <option value="">-- Select Query Type --</option>
                    <option value="Order Related">Order Related</option>
                    <option value="Product Info">Product Info</option>
                    <option value="Return/Exchange">Return/Exchange</option>
                    <option value="Other">Other</option>
                </select>

                <textarea name="message" rows="5" placeholder="Type your query here..." required 
                          class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3B8A9C] transition-all duration-300 hover:shadow-md"></textarea>

                <button type="submit" 
                        class="w-full bg-[#3B8A9C] text-white py-3 rounded-lg hover:bg-[#337685] transition-all duration-300 transform hover:scale-105">Send Message</button>
            </form>
        </div>

        <div id="mapCard" class="bg-white p-8 rounded-2xl shadow-xl w-full fade-in scale-95">
            <h2 class="text-2xl font-bold mb-4 text-[#3B8A9C]">Visit Our Location</h2>
            <div class="flex flex-col space-y-2 mb-4">
                <p class="flex items-center text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#3B8A9C]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    123 Model Town, Jalandhar, Punjab, India
                </p>
                <p class="flex items-center text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#3B8A9C]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    +91 98765 43210
                </p>
                <p class="flex items-center text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#3B8A9C]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    contact@yourbusiness.com
                </p>
            </div>
            <div class="map-container" id="map"></div>
        </div>
    </div>

    <script>
        // Fade-in animation on page load
        window.addEventListener('DOMContentLoaded', () => {
            document.getElementById('formCard').classList.add('show');
            document.getElementById('mapCard').classList.add('show');
        });

        // Google Maps integration
        function initMap() {
            // Coordinates for Jalandhar (centered approximately)
            const jalandhar = { lat: 31.326, lng: 75.576 };
            
            // Create map centered at Jalandhar
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: jalandhar,
                mapTypeControl: false,
                scrollwheel: false,
                styles: [
                    {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#e9e9e9"
                            },
                            {
                                "lightness": 17
                            }
                        ]
                    },
                    {
                        "featureType": "landscape",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#f5f5f5"
                            },
                            {
                                "lightness": 20
                            }
                        ]
                    }
                ]
            });
            
            // Add marker for business location
            const businessLocation = { lat: 31.3221, lng: 75.5731 }; // Adjust to your exact business location in Jalandhar
            const marker = new google.maps.Marker({
                position: businessLocation,
                map: map,
                title: "Our Location",
                animation: google.maps.Animation.DROP
            });
            
            // Add info window
            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div style="padding: 8px; max-width: 200px;">
                        <h3 style="margin: 0 0 8px; font-weight: bold; color: #3B8A9C;">Your Business Name</h3>
                        <p style="margin: 0; font-size: 14px;">123 Model Town, Jalandhar, Punjab, India</p>
                    </div>
                `
            });
            
            marker.addListener("click", () => {
                infoWindow.open(map, marker);
            });
        }
    </script>
    
    <!-- Replace YOUR_API_KEY with your actual Google Maps API key -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>
</body>
</html>