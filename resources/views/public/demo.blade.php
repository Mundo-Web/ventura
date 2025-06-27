@extends('components.public.matrix', ['pagina' => 'contacto'])

@section('css_importados')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .booking-card {
            max-width: 500px;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: white;
        }
        
        .booking-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .booking-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1a202c;
        }
        
        .booking-content {
            padding: 1.5rem;
        }
        
        .date-input-container {
            display: flex;
            align-items: center;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            padding: 0.5rem;
        }
        
        .date-input {
            flex: 1;
            border: none;
            outline: none;
            padding: 0.25rem 0.5rem;
        }
        
        .selected-range {
            margin-top: 1rem;
            padding: 0.75rem;
            background-color: #f7fafc;
            border-radius: 0.375rem;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            font-weight: 500;
            cursor: pointer;
        }
        
        .btn-primary {
            background-color: #4f46e5;
            color: white;
            width: 100%;
            margin-top: 0.5rem;
        }
        
        .btn-primary:hover {
            background-color: #4338ca;
        }
        
        .btn-icon {
            padding: 0.25rem;
            background: transparent;
            border: none;
            color: #64748b;
        }
        
        .btn-icon:hover {
            color: #ef4444;
        }
        
        .booking-list {
            margin-top: 1rem;
        }
        
        .booking-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem;
            background-color: #f7fafc;
            border-radius: 0.375rem;
            margin-bottom: 0.5rem;
        }
        
        .booking-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 9999px;
            font-size: 0.75rem;
        }
        
        /* Flatpickr custom styles */
        .check-in-date:not(.check-in-out-date) {
            background: linear-gradient(to right, white 50%, #e2e8f0 50%) !important;
            border-radius: 0 !important;
        }
        
        .check-out-date:not(.check-in-out-date) {
            background: linear-gradient(to right, #e2e8f0 50%, white 50%) !important;
            border-radius: 0 !important;
        }
        
        .check-in-out-date {
            background: #e2e8f0 !important;
            border-radius: 0 !important;
        }
        
        .flatpickr-day.selected.startRange {
            border-radius: 50% 0 0 50% !important;
        }
        
        .flatpickr-day.selected.endRange {
            border-radius: 0 50% 50% 0 !important;
        }

        .blocked-date {
            background-color: #e2e8f0 !important;
            border-radius: 0 !important;
            color: #64748b !important;
            cursor: not-allowed !important;
        }

        .flatpickr-disabled{
            background: #e2e8f0 !important;
            border-radius: 100%!important;
        }
    </style>
@stop

@section('content')

<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-8 text-center">Continuous Bookings Example</h1>
    
    <div class="booking-card">
        <div class="booking-header">
            <h2 class="booking-title">Booking Date Range</h2>
        </div>
        <div class="booking-content">
            <div class="date-input-container">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 text-gray-500">
                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                    <line x1="16" x2="16" y1="2" y2="6"></line>
                    <line x1="8" x2="8" y1="2" y2="6"></line>
                    <line x1="3" x2="21" y1="10" y2="10"></line>
                </svg>
                <input 
                    id="date-range-picker" 
                    type="text" 
                    placeholder="Select check-in and check-out dates" 
                    class="date-input" 
                    readonly
                >
            </div>
            
            <div id="selected-range-container" class="selected-range" style="display: none;">
                <p class="text-sm font-medium">Selected Range:</p>
                <p id="selected-range-text" class="text-sm"></p>
                <button id="add-booking-btn" class="btn btn-primary">Add Booking</button>
            </div>
            
            <div id="bookings-container" class="booking-list" style="display: none;">
                <h3 class="text-sm font-medium mb-2">Existing Bookings:</h3>
                <div id="bookings-list" class="space-y-2">
                    <!-- Bookings will be added here dynamically -->
                </div>
            </div>
        </div>
    </div>
</div>


@section('scripts_importados')
    
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DOM elements
            const datePickerInput = document.getElementById('date-range-picker');
            
            const selectedRangeContainer = document.getElementById('selected-range-container');
            const selectedRangeText = document.getElementById('selected-range-text');
            
            const addBookingBtn = document.getElementById('add-booking-btn');
            const bookingsContainer = document.getElementById('bookings-container');
            const bookingsList = document.getElementById('bookings-list');
            
            // State
            let dateRange = [];
            let bookings = [
                // Example of existing bookings
                { checkIn: '2025-06-27', checkOut: '2025-06-28' },
                { checkIn: '2025-06-28', checkOut: '2025-06-29' },
                { checkIn: '2025-07-01', checkOut: '2025-07-03' },
            ];

            let flatpickrInstance = null;
            
            // Initialize bookings list
            // renderBookings();
            
            // Function to get all dates between two dates (inclusive)
            function getDatesBetween(startDate, endDate) {
                const dates = [];
                let currentDate = new Date(startDate);
                const end = new Date(endDate);
                
                while (currentDate <= end) {
                    dates.push(new Date(currentDate).toISOString().split('T')[0]);
                    currentDate.setDate(currentDate.getDate() + 1);
                }
                
                return dates;
            }
            
            // Get all booked dates (including check-in and check-out dates)
            function getBookedDates() {
                const bookedDates = new Set();
                
                bookings.forEach(booking => {
                    // Get all dates in the booking range
                    const datesInRange = getDatesBetween(booking.checkIn, booking.checkOut);
                    
                    // Add all dates to the set
                    datesInRange.forEach(date => bookedDates.add(date));
                });
                
                return Array.from(bookedDates);
            }
            
            // Función para comprobar si una fecha es una fecha de entrada o de salida
            function isCheckInOrCheckOut(date) {
                return bookings.some(booking => 
                    booking.checkIn === date || booking.checkOut === date
                );
            }
            
            // Initialize Flatpickr
            function initFlatpickr() {
                const bookedDates = getBookedDates();
                console.log('Booked Dates:', bookedDates);
                flatpickrInstance = flatpickr(datePickerInput, {
                    mode: "range",
                    dateFormat: "Y-m-d",
                    minDate: "today",
                    allowSameDay: false, // Allow selecting the same day for check-in and check-out
                    
                    // Disable all dates that are already booked
                    disable: [
                        function(date) {
                            const dateStr = date.toISOString().split('T')[0];
                            
                            // Check if this date is already booked
                            if (bookedDates.includes(dateStr)) {
                                // If it's a check-in or check-out date, we need special handling
                                if (isCheckInOrCheckOut(dateStr)) {
                                    // Find all bookings where this date is either check-in or check-out
                                    const relevantBookings = bookings.filter(booking => 
                                        booking.checkIn === dateStr || booking.checkOut === dateStr
                                    );
                                    
                                    // If this date is both a check-out and check-in date for different bookings,
                                    // it should be completely blocked
                                    const isCheckOut = relevantBookings.some(booking => booking.checkOut === dateStr);
                                    const isCheckIn = relevantBookings.some(booking => booking.checkIn === dateStr);
                                    
                                    if (isCheckOut && isCheckIn) {
                                        return true; // Block completely
                                    }
                                    
                                    // Otherwise, allow it (special handling will be done in onDayCreate)
                                    return false;
                                }
                                
                                // For dates that are not check-in or check-out, block completely
                                return true;
                            }
                            
                            return false;
                        }
                    ],
                    
                    // Customize the appearance of days
                    onDayCreate: function(dObj, dStr, fp, dayElem) {
                        const dateStr = dayElem.dateObj.toISOString().split('T')[0];

                        // Style check-in dates
                        if (bookings.some(booking => booking.checkIn === dateStr)) {
                            dayElem.classList.add('check-in-date');
                        }
                        
                        // Style check-out dates
                        if (bookings.some(booking => booking.checkOut === dateStr)) {
                            dayElem.classList.add('check-out-date');
                        }
                        
                        // Style dates that are both check-in and check-out
                        if (bookings.some(booking => booking.checkIn === dateStr) && 
                            bookings.some(booking => booking.checkOut === dateStr)) {
                            dayElem.classList.add('check-in-out-date');
                        }
                    },
                    
                    onChange: function(selectedDates, dateStr) {
                        if (selectedDates.length > 0) {
                            dateRange = selectedDates.map(date => 
                                date.toISOString().split('T')[0]
                            );
                            
                            updateSelectedRangeDisplay();
                        }
                    }
                    
                });
            }
            
            // Initialize Flatpickr
            initFlatpickr();
            
            // Update the selected range display
            function updateSelectedRangeDisplay() {
                if (dateRange.length > 0) {
                    selectedRangeContainer.style.display = 'block';
                    
                    if (dateRange.length === 1) {
                        selectedRangeText.textContent = `Check-in: ${dateRange[0]} — Seleccione fecha de check-out`;
                    } else {
                        selectedRangeText.textContent = `Check-in: ${dateRange[0]} — Check-out: ${dateRange[1]}`;
                    }
                } else {
                    selectedRangeContainer.style.display = 'none';
                }
            }
            
            // Add a new booking
            function addBooking() {
                if (dateRange.length >= 2) {
                    const newBooking = {
                        id: Date.now().toString(),
                        checkIn: dateRange[0],
                        checkOut: dateRange[1] || dateRange[0],
                    };
                    
                    // Validación adicional para asegurar que hay al menos una noche
                    const checkInDate = new Date(newBooking.checkIn);
                    const checkOutDate = new Date(newBooking.checkOut);
                    const diffTime = checkOutDate - checkInDate;
                    const diffDays = diffTime / (1000 * 60 * 60 * 24);
                    
                    if (diffDays < 1) {
                        alert('Debe haber al menos una noche entre el check-in y el check-out');
                        return;
                    }

                    bookings.push(newBooking);
                    dateRange = [];
                    
                    // Reset the input field
                    datePickerInput.value = '';
                    selectedRangeContainer.style.display = 'none';
                    
                    // Render bookings
                    // renderBookings();
                    
                    // Destroy and reinitialize Flatpickr to update disabled dates
                    flatpickrInstance.destroy();
                    initFlatpickr();
                } else {
                    alert('Por favor seleccione un rango de fechas válido (check-in y check-out)');
                }
            }
            
            // Delete a booking
            function deleteBooking(id) {
                bookings = bookings.filter(booking => booking.id !== id);
                
                // Render bookings
                // renderBookings();
                
                // Destroy and reinitialize Flatpickr to update disabled dates
                flatpickrInstance.destroy();
                initFlatpickr();
            }
            
            // Render bookings
            function renderBookings() {
                if (bookings.length > 0) {
                    bookingsContainer.style.display = 'block';
                    
                    // Clear bookings list
                    bookingsList.innerHTML = '';
                    
                    // Add bookings
                    bookings.forEach(booking => {
                        const bookingItem = document.createElement('div');
                        bookingItem.className = 'booking-item';
                        
                        const bookingText = booking.checkIn === booking.checkOut 
                            ? `${booking.checkIn} (Same day)`
                            : `${booking.checkIn} → ${booking.checkOut}`;
                        
                            bookingItem.innerHTML = `
                                <div>
                                    <span class="booking-badge">${booking.checkIn} → ${booking.checkOut}</span>
                                </div>
                                <button class="btn-icon delete-booking" data-id="${booking.id}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 6h18"></path>
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                        <line x1="10" x2="10" y1="11" y2="17"></line>
                                        <line x1="14" x2="14" y1="11" y2="17"></line>
                                    </svg>
                                </button>
                            `;
                        
                        bookingsList.appendChild(bookingItem);
                    });
                    
                    // Add event listeners to delete buttons
                    document.querySelectorAll('.delete-booking').forEach(button => {
                        button.addEventListener('click', function() {
                            const id = this.getAttribute('data-id');
                            deleteBooking(id);
                        });
                    });
                } else {
                    bookingsContainer.style.display = 'none';
                }
            }
            
            // Event listeners
            addBookingBtn.addEventListener('click', addBooking);
        });
    </script>
    
    <script src="{{ asset('js/storage.extend.js') }}"></script>

@stop

@stop
