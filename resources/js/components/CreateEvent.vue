<template>
  <!-- Container for the Create Event form -->
  <div class="p-6 bg-white rounded shadow-md max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Create Event</h1>
    <form @submit.prevent="submitEvent" class="flex flex-col space-y-4">
      <!-- Event Name input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Event Name</span>
        <input 
          v-model="event.name" 
          type="text" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
          required
        />
      </label>
      
      <!-- Event Description input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Description</span>
        <textarea 
          v-model="event.description" 
          rows="4"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          placeholder="Describe your event..."
          required
        ></textarea>
      </label>
      
      <!-- Event Type input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Event Type</span>
        <select 
          v-model="event.event_type" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          required
          @change="updateEventTypeFields"
        >
          <option disabled value="">Please select</option>
          <option value="wedding">Wedding</option>
          <option value="birthday">Birthday Party</option>
          <option value="corporate">Corporate Event</option>
          <option value="conference">Conference</option>
          <option value="workshop">Workshop</option>
          <option value="concert">Concert</option>
          <option value="exhibition">Exhibition</option>
          <option value="graduation">Graduation</option>
          <option value="anniversary">Anniversary</option>
          <option value="other">Other</option>
        </select>
      </label>

      <!-- Event type specific fields -->
      <div v-if="event.event_type" class="mt-4 p-4 bg-gray-50 rounded">
        <h3 class="text-lg font-semibold mb-4">Event Details</h3>

        <!-- Get the current event type's fields -->
        <div v-if="event.event_type_specific_fields[event.event_type]" class="space-y-4">
          <template v-for="(field, fieldName) in event.event_type_specific_fields[event.event_type]" :key="fieldName">
            <label class="block" v-if="field !== null && field !== undefined">
              <span class="text-gray-700 font-semibold">{{ fieldName.replace('_', ' ').replace(/\w+/g, (txt) => txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()) }}</span>
              <input 
                v-model="event.event_type_specific_fields[event.event_type][fieldName]" 
                :type="fieldName.includes('date') ? 'date' : fieldName.includes('number') ? 'number' : 'text'" 
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                :required="eventTypeRequirements[event.event_type]?.required.includes(fieldName)"
              />
            </label>
          </template>
        </div>
      </div>

      <!-- Date and Time inputs -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <label class="block">
          <span class="text-gray-700 font-semibold">Start Date</span>
          <input 
            v-model="event.start_date" 
            type="date" 
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
            required
          />
        </label>
        
        <label class="block">
          <span class="text-gray-700 font-semibold">Start Time</span>
          <input 
            v-model="event.start_time" 
            type="time" 
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
            required
          />
        </label>
        
        <label class="block">
          <span class="text-gray-700 font-semibold">End Date</span>
          <input 
            v-model="event.end_date" 
            type="date" 
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
            required
          />
        </label>
        
        <label class="block">
          <span class="text-gray-700 font-semibold">End Time</span>
          <input 
            v-model="event.end_time" 
            type="time" 
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
            required
          />
        </label>
      </div>

      <!-- Venue Selection -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Venue</span>
        <select 
          v-model="event.venue_id" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          required
        >
          <option disabled value="">Please select a venue</option>
          <option v-for="venue in venues" :key="venue.id" :value="venue.id">
            {{ venue.name }} - {{ venue.city }}
          </option>
        </select>
      </label>

      <!-- Expected Attendees -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Expected Attendees</span>
        <input 
          v-model.number="event.expected_attendees" 
          type="number" 
          min="1"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
          required
        />
      </label>

      <!-- Budget -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Budget</span>
        <input 
          v-model.number="event.budget" 
          type="number" 
          step="0.01" 
          min="0"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
        />
      </label>

      <!-- Event Status -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Status</span>
        <select 
          v-model="event.status" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
        >
          <option value="draft">Draft</option>
          <option value="published">Published</option>
          <option value="cancelled">Cancelled</option>
          <option value="completed">Completed</option>
        </select>
      </label>

      <!-- Event Requirements -->
      <div class="block">
        <span class="text-gray-700 font-semibold">Event Requirements</span>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
          <label class="flex items-center space-x-2">
            <input type="checkbox" v-model="event.catering_required" class="rounded" />
            <i class="fas fa-utensils fa-lg text-blue-600"></i>
            <span class="text-gray-700 font-medium">Catering Required</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" v-model="event.security_required" class="rounded" />
            <i class="fas fa-shield-alt fa-lg text-blue-600"></i>
            <span class="text-gray-700 font-medium">Security Required</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" v-model="event.parking_required" class="rounded" />
            <i class="fas fa-parking fa-lg text-blue-600"></i>
            <span class="text-gray-700 font-medium">Parking Required</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" v-model="event.entertainment_required" class="rounded" />
            <i class="fas fa-music fa-lg text-blue-600"></i>
            <span class="text-gray-700 font-medium">Entertainment Required</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" v-model="event.audio_visual_required" class="rounded" />
            <i class="fas fa-video fa-lg text-blue-600"></i>
            <span class="text-gray-700 font-medium">Audio/Visual Required</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" v-model="event.decoration_required" class="rounded" />
            <i class="fas fa-paint-brush fa-lg text-blue-600"></i>
            <span class="text-gray-700 font-medium">Decoration Required</span>
          </label>
        </div>

        <!-- Catering Options -->
        <div v-if="event.catering_required" class="mt-4 p-4 bg-gray-50 rounded">
          <h3 class="text-lg font-semibold mb-4">Catering Details</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <label class="block">
              <span class="text-gray-700 font-semibold">Catering Type</span>
              <select v-model="event.catering_type" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <option value="buffet">Buffet</option>
                <option value="sit_down">Sit Down Dinner</option>
                <option value="cocktail">Cocktail Reception</option>
                <option value="custom">Custom Menu</option>
              </select>
            </label>
            <label class="block">
              <span class="text-gray-700 font-semibold">Menu Preferences</span>
              <select v-model="event.menu_preferences" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <option value="vegetarian">Vegetarian</option>
                <option value="vegan">Vegan</option>
                <option value="gluten_free">Gluten Free</option>
                <option value="halal">Halal</option>
                <option value="kosher">Kosher</option>
                <option value="regular">Regular</option>
              </select>
            </label>
            <label class="block">
              <span class="text-gray-700 font-semibold">Number of Guests</span>
              <input 
                v-model.number="event.catering_guest_count" 
                type="number" 
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                required
              />
            </label>
          </div>
        </div>

        <!-- Security Options -->
        <div v-if="event.security_required" class="mt-4 p-4 bg-gray-50 rounded">
          <h3 class="text-lg font-semibold mb-4">Security Details</h3>
          <div class="space-y-4">
            <label class="block">
              <span class="text-gray-700 font-semibold">Number of Security Personnel</span>
              <input 
                v-model.number="event.security_personnel_count" 
                type="number" 
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                required
              />
            </label>
            <label class="block">
              <span class="text-gray-700 font-semibold">Special Security Needs</span>
              <textarea 
                v-model="event.security_special_needs" 
                rows="3"
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
              ></textarea>
            </label>
          </div>
        </div>

        <!-- Parking Options -->
        <div v-if="event.parking_required" class="mt-4 p-4 bg-gray-50 rounded">
          <h3 class="text-lg font-semibold mb-4">Parking Details</h3>
          <div class="space-y-4">
            <label class="block">
              <span class="text-gray-700 font-semibold">Estimated Number of Vehicles</span>
              <input 
                v-model.number="event.parking_vehicle_count" 
                type="number" 
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                required
              />
            </label>
            <label class="block">
              <span class="text-gray-700 font-semibold">Special Parking Requirements</span>
              <textarea 
                v-model="event.parking_special_requirements" 
                rows="3"
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
              ></textarea>
            </label>
          </div>
        </div>

        <!-- Entertainment Options -->
        <div v-if="event.entertainment_required" class="mt-4 p-4 bg-gray-50 rounded">
          <h3 class="text-lg font-semibold mb-4">Entertainment Details</h3>
          <div class="space-y-4">
            <label class="block">
              <span class="text-gray-700 font-semibold">Type of Entertainment</span>
              <select v-model="event.entertainment_type" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <option value="live_band">Live Band</option>
                <option value="dj">DJ</option>
                <option value="magician">Magician</option>
                <option value="dancers">Dancers</option>
                <option value="other">Other</option>
              </select>
            </label>
            <label class="block">
              <span class="text-gray-700 font-semibold">Special Entertainment Requests</span>
              <textarea 
                v-model="event.entertainment_requests" 
                rows="3"
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
              ></textarea>
            </label>
          </div>
        </div>

        <!-- Audio/Visual Options -->
        <div v-if="event.audio_visual_required" class="mt-4 p-4 bg-gray-50 rounded">
          <h3 class="text-lg font-semibold mb-4">Audio/Visual Details</h3>
          <div class="space-y-4">
            <label class="block">
              <span class="text-gray-700 font-semibold">Required Equipment</span>
              <select v-model="event.av_equipment" multiple class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <option value="microphones">Microphones</option>
                <option value="speakers">Speakers</option>
                <option value="projector">Projector</option>
                <option value="sound_system">Sound System</option>
                <option value="lighting">Lighting</option>
              </select>
            </label>
            <label class="block">
              <span class="text-gray-700 font-semibold">AV Technical Requirements</span>
              <textarea 
                v-model="event.av_technical_requirements" 
                rows="3"
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
              ></textarea>
            </label>
          </div>
        </div>

        <!-- Decoration Options -->
        <div v-if="event.decoration_required" class="mt-4 p-4 bg-gray-50 rounded">
          <h3 class="text-lg font-semibold mb-4">Decoration Details</h3>
          <div class="space-y-4">
            <label class="block">
              <span class="text-gray-700 font-semibold">Decoration Style</span>
              <select v-model="event.decoration_style" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <option value="elegant">Elegant</option>
                <option value="modern">Modern</option>
                <option value="rustic">Rustic</option>
                <option value="themed">Themed</option>
                <option value="minimalist">Minimalist</option>
              </select>
            </label>
            <label class="block">
              <span class="text-gray-700 font-semibold">Color Scheme</span>
              <input 
                v-model="event.decoration_color_scheme" 
                type="color" 
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
              />
            </label>
            <label class="block">
              <span class="text-gray-700 font-semibold">Special Decor Requests</span>
              <textarea 
                v-model="event.decoration_special_requests" 
                rows="3"
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
              ></textarea>
            </label>
          </div>
        </div>
      </div>

      <!-- Special Instructions -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Special Instructions</span>
        <textarea 
          v-model="event.special_instructions" 
          rows="3"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          placeholder="Any special requirements or instructions..."
        ></textarea>
      </label>

      <!-- Contact Information -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <label class="block">
          <span class="text-gray-700 font-semibold">Contact Email</span>
          <input 
            v-model="event.contact_email" 
            type="email" 
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
          />
        </label>
        
        <label class="block">
          <span class="text-gray-700 font-semibold">Contact Phone</span>
          <input 
            v-model="event.contact_phone" 
            type="tel" 
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
          />
        </label>
      </div>

      <!-- Is Public Event -->
      <label class="flex items-center space-x-2">
        <input type="checkbox" v-model="event.is_public" class="rounded" />
        <span class="text-gray-700 font-medium">This is a public event</span>
      </label>

      <!-- Submit button -->
      <button 
        type="submit" 
        :disabled="isSubmitting"
        class="bg-blue-500 text-white py-2 px-4 rounded font-bold hover:bg-blue-600 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors"
      >
        {{ isSubmitting ? 'Creating...' : 'Create Event' }}
      </button>
    </form>
    
    <!-- Success or error message -->
    <div 
      v-if="message" 
      :class="messageClass"
      class="mt-4 p-3 rounded transition-all duration-300"
    >
      {{ message }}
    </div>
  </div>
</template>

<script>
export default {
  name: 'CreateEvent',
  data() {
    return {
      isSubmitting: false,
      event: {
        name: '',
        description: '',
        event_type: '',
        start_date: '',
        end_date: '',
        start_time: '',
        end_time: '',
        venue_id: '',
        venue: '',
        capacity: '',
        catering_required: false,
        catering_type: '',
        menu_preferences: '',
        catering_guest_count: '',
        security_required: false,
        security_personnel_count: '',
        security_special_needs: '',
        parking_required: false,
        parking_vehicle_count: '',
        parking_special_requirements: '',
        entertainment_required: false,
        entertainment_type: '',
        entertainment_requests: '',
        audio_visual_required: false,
        av_equipment: [],
        av_technical_requirements: '',
        decoration_required: false,
        decoration_style: '',
        decoration_color_scheme: '#ffffff',
        decoration_special_requests: '',
        special_instructions: '',
        contact_email: '',
        contact_phone: '',
        is_public: false,
        event_type_specific_fields: {
          wedding: {
            bride_name: '',
            groom_name: '',
            guest_list: '',
            catering: '',
            entertainment: '',
            photography: '',
            videography: '',
            music_band: '',
            wedding_theme: ''
          },
          birthday: {
            child_age: '',
            theme: '',
            guest_age_range: '',
            entertainment: '',
            cake_design: '',
            party_favors: '',
            balloon_decor: ''
          },
          corporate: {
            company_name: '',
            department: '',
            purpose: '',
            attendees_profile: '',
            speakers: '',
            presentation_materials: '',
            catering: '',
            parking_requirements: ''
          },
          conference: {
            topics: '',
            keynote_speakers: '',
            registration_fee: '',
            accommodation: '',
            workshop_sessions: '',
            exhibition_space: '',
            networking_events: ''
          },
          workshop: {
            trainer: '',
            topics: '',
            materials_required: '',
            prerequisites: '',
            certification: '',
            practical_sessions: '',
            assessment: ''
          },
          concert: {
            artist: '',
            genre: '',
            ticket_price: '',
            stage_requirements: '',
            sound_system: '',
            lighting: '',
            backstage_requirements: '',
            security: ''
          },
          exhibition: {
            exhibitors: '',
            categories: '',
            entry_fee: '',
            special_requirements: '',
            workshops: '',
            demonstrations: '',
            networking_sessions: ''
          },
          graduation: {
            institution: '',
            degree_level: '',
            number_of_graduates: '',
            guest_speakers: '',
            ceremony_format: '',
            photography: ''
          },
          anniversary: {
            years: '',
            celebration_type: '',
            guest_list: '',
            entertainment: '',
            catering: '',
            special_decor: ''
          },
          other: {
            event_description: '',
            expected_attendees: ''
          }
        }
      },
      venues: [],
      message: '',
      eventTypes: [
        { value: 'wedding', text: 'Wedding' },
        { value: 'birthday', text: 'Birthday' },
        { value: 'corporate', text: 'Corporate' },
        { value: 'conference', text: 'Conference' },
        { value: 'workshop', text: 'Workshop' },
        { value: 'concert', text: 'Concert' },
        { value: 'exhibition', text: 'Exhibition' },
        { value: 'graduation', text: 'Graduation' },
        { value: 'anniversary', text: 'Anniversary' },
        { value: 'other', text: 'Other' }
      ],
      eventTypeRequirements: {
        wedding: {
          required: ['bride_name', 'groom_name', 'guest_list', 'catering'],
          optional: ['entertainment', 'photography', 'videography', 'music_band', 'wedding_theme']
        },
        birthday: {
          required: ['child_age', 'theme', 'guest_age_range'],
          optional: ['entertainment', 'cake_design', 'party_favors', 'balloon_decor']
        },
        corporate: {
          required: ['company_name', 'department', 'purpose', 'attendees_profile'],
          optional: ['speakers', 'presentation_materials', 'catering', 'parking_requirements']
        },
        conference: {
          required: ['topics', 'keynote_speakers', 'registration_fee', 'accommodation'],
          optional: ['workshop_sessions', 'exhibition_space', 'networking_events']
        },
        workshop: {
          required: ['trainer', 'topics', 'materials_required', 'prerequisites'],
          optional: ['certification', 'practical_sessions', 'assessment']
        },
        concert: {
          required: ['artist', 'genre', 'ticket_price', 'stage_requirements'],
          optional: ['sound_system', 'lighting', 'backstage_requirements', 'security']
        },
        exhibition: {
          required: ['exhibitors', 'categories', 'entry_fee', 'special_requirements'],
          optional: ['workshops', 'demonstrations', 'networking_sessions']
        },
        graduation: {
          required: ['institution', 'degree_level', 'number_of_graduates'],
          optional: ['guest_speakers', 'ceremony_format', 'photography']
        },
        anniversary: {
          required: ['years', 'celebration_type', 'guest_list'],
          optional: ['entertainment', 'catering', 'special_decor']
        },
        other: {
          required: ['event_description', 'expected_attendees'],
          optional: []
        }
      }
    };
  },
  computed: {
    // Get required fields based on event type
    getRequiredFields() {
      if (!this.event.event_type) return [];
      return this.eventTypeRequirements[this.event.event_type]?.required || [];
    },

    // Get optional fields based on event type
    getOptionalFields() {
      if (!this.event.event_type) return [];
      return this.eventTypeRequirements[this.event.event_type]?.optional || [];
    },
    messageClass() {
      return this.message.toLowerCase().includes('error')
        ? 'bg-red-100 text-red-700 border border-red-300'
        : 'bg-green-100 text-green-700 border border-green-300';
    }
  },
  async mounted() {
    await this.loadVenues();
  },
  methods: {
    // Update event type specific fields when event type changes
    updateEventTypeFields() {
      // Reset all event type specific fields
      Object.keys(this.event.event_type_specific_fields).forEach(type => {
        if (typeof this.event.event_type_specific_fields[type] === 'object') {
          Object.keys(this.event.event_type_specific_fields[type]).forEach(field => {
            this.event.event_type_specific_fields[type][field] = '';
          });
        }
      });

      // Initialize fields for selected event type
      if (this.event.event_type) {
        const eventType = this.event.event_type_specific_fields[this.event.event_type];
        if (eventType) {
          Object.keys(eventType).forEach(field => {
            eventType[field] = '';
          });
        }
      }
    },
    async loadVenues() {
      try {
        const response = await this.$axios.get('/api/venues');
        this.venues = response.data;
      } catch (error) {
        console.error('Error loading venues:', error);
        this.message = 'Error loading venues. Please refresh the page.';
      }
    },

    async submitEvent() {
      this.isSubmitting = true;
      this.message = '';

      try {
        // Validation
        if (!this.event.name || !this.event.description || !this.event.event_type) {
          throw new Error('Please fill in all required fields.');
        }

        if (!this.event.start_date || !this.event.start_time || !this.event.end_date || !this.event.end_time) {
          throw new Error('Please provide complete date and time information.');
        }

        if (!this.event.venue_id) {
          throw new Error('Please select a venue.');
        }

        if (this.event.event_type === 'other' && !this.event.custom_event_type) {
          throw new Error('Please specify the custom event type.');
        }

        const startDateTime = new Date(`${this.event.start_date}T${this.event.start_time}`);
        const endDateTime = new Date(`${this.event.end_date}T${this.event.end_time}`);

        if (endDateTime <= startDateTime) {
          throw new Error('End date and time must be after start date and time.');
        }

        if (startDateTime < new Date()) {
          throw new Error('Event cannot be scheduled in the past.');
        }

        // Use custom event type if selected
        const payload = {
          ...this.event,
          event_type:
            this.event.event_type === 'other'
              ? this.event.custom_event_type
              : this.event.event_type
        };

        const response = await this.$axios.post('/api/events', payload);

        this.message = 'Event created successfully!';
        this.resetForm();
      } catch (error) {
        console.error(error);
        this.message = error.response?.data?.message || error.message || 'Error creating event.';
      } finally {
        this.isSubmitting = false;
      }
    },

    resetForm() {
      this.event = {
        name: '',
        description: '',
        event_type: '',
        custom_event_type: '',
        start_date: '',
        start_time: '',
        end_date: '',
        end_time: '',
        venue_id: '',
        expected_attendees: null,
        budget: null,
        status: 'draft',
        catering_required: false,
        decoration_required: false,
        sound_system_required: false,
        photography_required: false,
        security_required: false,
        parking_required: false,
        special_instructions: '',
        contact_email: '',
        contact_phone: '',
        is_public: false,
        organizer_id: null
      };
    }
  }
};
</script>
