 // Populate the year dropdown
        const yearSelect = document.getElementById('year');
        const currentYear = new Date().getFullYear();
        for (let i = currentYear; i >= 1900; i--) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = i;
            yearSelect.appendChild(option);
        }

        // Populate the month dropdown
        const monthSelect = document.getElementById('month');
        for (let i = 1; i <= 12; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = i;
            monthSelect.appendChild(option);
        }

        // Populate the day dropdown
        const daySelect = document.getElementById('day');
        for (let i = 1; i <= 31; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = i;
            daySelect.appendChild(option);
        }

        // Populate the time slots
        const timeSlotsDiv = document.getElementById('time-slots');
        const startHour = 14; // 2:00 PM
        const endHour = 23;   // 11:00 PM
        for (let i = startHour; i <= endHour; i++) {
            const hour = i % 12 === 0 ? 12 : i % 12;
            const period = i < 12 ? 'AM' : 'PM';
            const time = `${hour}:00 ${period}`;

            const timeSlotDiv = document.createElement('div');
            timeSlotDiv.className = 'time-slot';

            const radioButton = document.createElement('input');
            radioButton.type = 'radio';
            radioButton.name = 'time';
            radioButton.value = time;

            const label = document.createElement('label');
            label.textContent = time;

            timeSlotDiv.appendChild(radioButton);
            timeSlotDiv.appendChild(label);
            timeSlotsDiv.appendChild(timeSlotDiv);
        }

        function getDate() {
            const selectedYear = document.getElementById('year').value;
            const selectedMonth = document.getElementById('month').value;
            const selectedDay = document.getElementById('day').value;
            const selectedTime = document.querySelector('input[name="time"]:checked').value;

            const output = `Selected Date and Time: Year=${selectedYear}, Month=${selectedMonth}, Day=${selectedDay}, Time=${selectedTime}`;
            document.getElementById('output').textContent = output;

            // Make the selected time unselectable
            const radioButtons = document.querySelectorAll('input[name="time"]');
            radioButtons.forEach(button => {
                if (button.value === selectedTime) {
                    button.disabled = true;
                }
            });
        }