<template>
    <FullCalendar :options="calendarOptions" />
  </template>
  
  <script>
  import { defineComponent, ref, onMounted } from 'vue';
  import FullCalendar from '@fullcalendar/vue3';
  import dayGridPlugin from '@fullcalendar/daygrid';
  import timeGridPlugin from '@fullcalendar/timegrid';
  import interactionPlugin from '@fullcalendar/interaction';
  
  export default defineComponent({
    name: 'Calendar',
    components: {
      FullCalendar
    },
    setup() {
      const calendarOptions = ref({
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        events: [],
        dateClick(info) {
          alert('Clicked on: ' + info.dateStr);
        }
      });
  
      const fetchEvents = async () => {
        try {
          const response = await fetch('/api/events');
          const data = await response.json();
          calendarOptions.value.events = data;
        } catch (error) {
          console.error('Error fetching events:', error);
        }
      };
  
      onMounted(fetchEvents);
  
      return {
        calendarOptions
      };
    }
  });
  </script>
  
  <style scoped>
  /* @import '@fullcalendar/common/main.css'; */
  /* @import '@fullcalendar/daygrid/main.css'; */
  /* @import '@fullcalendar/timegrid/main.css'; */
  .fc {
  /* Add a background image or color to resemble a registration form left is top right is bottom */
  background-image: linear-gradient(to top, #00000052, #7700ff2c); 
  /* background-size: 100% 300px; */
  background-position: 0% 100%;
  border: 1px solid #ddd;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.fc-header {
  background-color: #333;
  color: #fff;
  padding: 10px;
  border-bottom: 1px solid #ddd;
}

.fc-body {
  padding: 20px;
}

.fc-event {
  background-color: #337ab7;
  color: #fff;
  border-radius: 5px;
  padding: 5px;
  cursor: pointer;
}

.fc-event:hover {
  background-color: #23527c;
}

.fc-day-grid-container {
  background-color: #f9f9f9;
  padding: 20px;
}

.fc-day-grid {
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 10px;
  padding: 20px;
}

.fc-day-number {
  font-size: 18px;
  font-weight: bold;
  color: #333;
}

.fc-day {
  padding: 10px;
  border-bottom: 1px solid #ddd;
}
  </style>  