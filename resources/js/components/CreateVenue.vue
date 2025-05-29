<template>
  <!-- Container for the Create Venue form -->
  <div class="p-6 bg-white rounded shadow-md max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Create Venue</h1>
    <form @submit.prevent="submitVenue" class="flex flex-col space-y-4">
      <!-- Venue Name input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Venue Name</span>
        <input 
          v-model="venue.name" 
          type="text" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
          required
        />
      </label>
      
      <!-- Address input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Address</span>
        <input 
          v-model="venue.address" 
          type="text" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
          required
        />
      </label>
      
      <!-- City input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">City</span>
        <input 
          v-model="venue.city" 
          type="text" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
          required
        />
      </label>
      
      <!-- State input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">State/Province</span>
        <input 
          v-model="venue.state" 
          type="text" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
        />
      </label>
      
      <!-- Country input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Country</span>
        <input 
          v-model="venue.country" 
          type="text" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
          required
        />
      </label>
      
      <!-- Zip Code input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Zip Code</span>
        <input 
          v-model="venue.zip_code" 
          type="text" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
        />
      </label>
      
      <!-- Latitude input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Latitude</span>
        <input 
          v-model.number="venue.latitude" 
          type="number" 
          step="0.000001" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
        />
      </label>
      
      <!-- Longitude input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Longitude</span>
        <input 
          v-model.number="venue.longitude" 
          type="number" 
          step="0.000001" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
        />
      </label>
      
      <!-- Capacity input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Capacity</span>
        <input 
          v-model.number="venue.capacity" 
          type="number" 
          min="1"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
          required
        />
      </label>
      
      <!-- Price per hour input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Price per Hour</span>
        <input 
          v-model.number="venue.price_per_hour" 
          type="number" 
          step="0.01" 
          min="0"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
          required
        />
      </label>
      
      <!-- Venue Type input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Venue Type</span>
        <select 
          v-model="venue.venue_type" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          required
        >
          <option disabled value="">Please select</option>
          <option value="cafe">Cafe</option>
          <option value="restaurant">Restaurant</option>
          <option value="open_space">Open Space</option>
          <option value="hall">Hall</option>
          <option value="marquee">Wedding Marquee</option>
          <option value="conference_room">Conference Room</option>
          <option value="event_center">Event Center</option>
          <option value="rooftop">Rooftop</option>
          <option value="other">Other</option>
        </select>
      </label>
      
      <!-- Custom venue type -->
      <label v-if="venue.venue_type === 'other'" class="block">
        <span class="text-gray-700 font-semibold">Custom Venue Type</span>
        <input 
          v-model="venue.custom_venue_type" 
          type="text" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
          required
        />
      </label>

      <!-- Conditional fields for custom venue type -->
      <div v-if="venue.venue_type === 'other'" class="space-y-4 p-4 bg-gray-50 rounded">
        <h3 class="text-lg font-semibold text-gray-700">Additional Details</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <label class="block">
            <span class="text-gray-700 font-semibold">Floor Area (sqft)</span>
            <input 
              v-model.number="venue.floor_area_sqft" 
              type="number" 
              min="0"
              class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
            />
          </label>
          
          <label class="block">
            <span class="text-gray-700 font-semibold">Layout Type</span>
            <input 
              v-model="venue.layout_type" 
              type="text" 
              placeholder="e.g. open, banquet, conference" 
              class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
            />
          </label>
          
          <label class="block">
            <span class="text-gray-700 font-semibold">Contact Email</span>
            <input 
              v-model="venue.contact_email" 
              type="email" 
              class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
            />
          </label>
          
          <label class="block">
            <span class="text-gray-700 font-semibold">Contact Phone</span>
            <input 
              v-model="venue.contact_phone" 
              type="tel" 
              maxlength="20" 
              class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
            />
          </label>
          
          <label class="block">
            <span class="text-gray-700 font-semibold">Video Tour URL</span>
            <input 
              v-model="venue.video_tour_url" 
              type="url" 
              class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
            />
          </label>
          
          <label class="block">
            <span class="text-gray-700 font-semibold">Minimum Booking Hours</span>
            <input 
              v-model.number="venue.minimum_booking_hours" 
              type="number" 
              min="1"
              class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
            />
          </label>
          
          <label class="block">
            <span class="text-gray-700 font-semibold">Max Booking Hours</span>
            <input 
              v-model.number="venue.max_booking_hours" 
              type="number" 
              min="1"
              class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
            />
          </label>
          
          <label class="block">
            <span class="text-gray-700 font-semibold">Security Deposit</span>
            <input 
              v-model.number="venue.security_deposit" 
              type="number" 
              step="0.01" 
              min="0"
              class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
            />
          </label>
        </div>

        <label class="block">
          <span class="text-gray-700 font-semibold">Pricing Model</span>
          <select 
            v-model="venue.pricing_model" 
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          >
            <option disabled value="">Please select</option>
            <option value="per_hour">Per Hour</option>
            <option value="per_day">Per Day</option>
            <option value="custom">Custom</option>
          </select>
        </label>

        <!-- Facility Checkboxes -->
        <div class="space-y-2">
          <span class="text-gray-700 font-semibold">Facilities</span>
          <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
            <label class="flex items-center space-x-2">
              <input type="checkbox" v-model="venue.restrooms_available" class="rounded" />
              <span class="text-gray-700">Restrooms Available</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="checkbox" v-model="venue.air_conditioning" class="rounded" />
              <span class="text-gray-700">Air Conditioning</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="checkbox" v-model="venue.heating" class="rounded" />
              <span class="text-gray-700">Heating</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="checkbox" v-model="venue.security_staff" class="rounded" />
              <span class="text-gray-700">Security Staff</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="checkbox" v-model="venue.internet_access" class="rounded" />
              <span class="text-gray-700">Internet Access</span>
            </label>
          </div>
        </div>

        <label class="block">
          <span class="text-gray-700 font-semibold">Status</span>
          <select 
            v-model="venue.status" 
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          >
            <option value="pending">Pending</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="maintenance">Maintenance</option>
            <option value="reserved">Reserved</option>
          </select>
        </label>
      </div>

      <!-- Available From input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Available From</span>
        <input 
          v-model="venue.available_from" 
          type="time" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
        />
      </label>
      
      <!-- Available To input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Available To</span>
        <input 
          v-model="venue.available_to" 
          type="time" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
        />
      </label>
      
      <!-- Optional Features checkboxes -->
      <div class="block">
        <span class="text-gray-700 font-semibold">Optional Features</span>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
          <label class="flex items-center space-x-2">
            <input type="checkbox" v-model="venue.parking_available" class="rounded" />
            <i class="fas fa-parking fa-lg text-blue-600"></i>
            <span class="text-gray-700 font-medium">Parking Available</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" v-model="venue.wheelchair_accessible" class="rounded" />
            <i class="fas fa-wheelchair fa-lg text-blue-600"></i>
            <span class="text-gray-700 font-medium">Wheelchair Accessible</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" v-model="venue.kitchen_facilities" class="rounded" />
            <i class="fas fa-utensils fa-lg text-blue-600"></i>
            <span class="text-gray-700 font-medium">Kitchen Facilities</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" v-model="venue.catering_available" class="rounded" />
            <i class="fas fa-concierge-bell fa-lg text-blue-600"></i>
            <span class="text-gray-700 font-medium">Catering Available</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" v-model="venue.sound_system" class="rounded" />
            <i class="fas fa-volume-up fa-lg text-blue-600"></i>
            <span class="text-gray-700 font-medium">Sound System</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" v-model="venue.stage_available" class="rounded" />
            <i class="fas fa-theater-masks fa-lg text-blue-600"></i>
            <span class="text-gray-700 font-medium">Stage Available</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" v-model="venue.outdoor_area" class="rounded" />
            <i class="fas fa-tree fa-lg text-blue-600"></i>
            <span class="text-gray-700 font-medium">Outdoor Area</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" v-model="venue.decor_services" class="rounded" />
            <i class="fas fa-paint-roller fa-lg text-blue-600"></i>
            <span class="text-gray-700 font-medium">Decor Services</span>
          </label>
        </div>
      </div>
      
      <!-- Lighting Options input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Lighting Options</span>
        <textarea 
          v-model="venue.lighting_options" 
          rows="3"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          placeholder="Describe available lighting options..."
        ></textarea>
      </label>
      
      <!-- Seating Arrangement Options input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Seating Arrangement Options</span>
        <textarea 
          v-model="venue.seating_arrangement_options" 
          rows="3"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          placeholder="Describe seating arrangement options..."
        ></textarea>
      </label>
      
      <!-- Custom Rules input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Custom Rules</span>
        <textarea 
          v-model="venue.custom_rules" 
          rows="3"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          placeholder="Enter any custom rules or restrictions..."
        ></textarea>
      </label>
      
      <!-- Booking Policy input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Booking Policy</span>
        <textarea 
          v-model="venue.booking_policy" 
          rows="3"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          placeholder="Enter booking policy details..."
        ></textarea>
      </label>
      
      <!-- Furniture details -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <label class="block">
          <span class="text-gray-700 font-semibold">Chairs</span>
          <input 
            v-model.number="venue.chairs" 
            type="number" 
            min="0"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
          />
        </label>
        
        <label class="block">
          <span class="text-gray-700 font-semibold">Tables</span>
          <input 
            v-model.number="venue.tables" 
            type="number" 
            min="0"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
          />
        </label>
      </div>

      <!-- Image Upload Component -->
      <div class="mt-4">
        <button 
          type="button" 
          @click="showImageUploader = !showImageUploader" 
          class="bg-green-500 text-white py-2 px-4 rounded font-bold hover:bg-green-600 transition-colors"
        >
          {{ showImageUploader ? 'Hide' : 'Upload Images' }}
        </button>
        <div v-if="showImageUploader" class="mt-2">
          <ImageUploader v-model="venue.photo_gallery" />
        </div>
      </div>

      <!-- Menu File Upload Component -->
      <div 
        v-if="venue.venue_type === 'other' || ['restaurant', 'cafe'].includes(venue.venue_type)" 
        class="mt-4"
      >
        <button 
          type="button" 
          @click="showFileUploader = !showFileUploader" 
          class="bg-purple-500 text-white py-2 px-4 rounded font-bold hover:bg-purple-600 transition-colors"
        >
          {{ showFileUploader ? 'Hide' : 'Upload Menu File' }}
        </button>
        <div v-if="showFileUploader" class="mt-2">
          <FileUploader v-model="venue.menu_file" />
        </div>
      </div>
      
      <!-- Submit button -->
      <button 
        type="submit" 
        :disabled="isSubmitting"
        class="bg-blue-500 text-white py-2 px-4 rounded font-bold hover:bg-blue-600 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors"
      >
        {{ isSubmitting ? 'Creating...' : 'Create Venue' }}
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
import ImageUploader from './ImageUploader.vue';
import FileUploader from './FileUploader.vue';

export default {
  name: 'CreateVenue',
  components: {
    ImageUploader,
    FileUploader
  },
  data() {
    return {
      isSubmitting: false,
      venue: {
        name: '',
        address: '',
        city: '',
        state: '',
        country: '',
        zip_code: '',
        latitude: null,
        longitude: null,
        capacity: null,
        price_per_hour: null,
        venue_type: '',
        custom_venue_type: '',
        floor_area_sqft: null,
        layout_type: '',
        contact_email: '',
        contact_phone: '',
        video_tour_url: '',
        minimum_booking_hours: null,
        max_booking_hours: null,
        pricing_model: '',
        security_deposit: null,
        restrooms_available: false,
        air_conditioning: false,
        heating: false,
        security_staff: false,
        internet_access: false,
        status: 'pending',
        menu_file: null,
        available_from: '',
        available_to: '',
        owner_id: null,
        parking_available: false,
        wheelchair_accessible: false,
        kitchen_facilities: false,
        catering_available: false,
        sound_system: false,
        stage_available: false,
        outdoor_area: false,
        decor_services: false,
        lighting_options: '',
        seating_arrangement_options: '',
        photo_gallery: [],
        custom_rules: '',
        booking_policy: '',
        chairs: null,
        tables: null
      },
      message: '',
      showImageUploader: false,
      showFileUploader: false
    };
  },
  computed: {
    messageClass() {
      return this.message.includes('Error') || this.message.includes('error')
        ? 'bg-red-100 text-red-700 border border-red-300'
        : 'bg-green-100 text-green-700 border border-green-300';
    }
  },
  methods: {
    async submitVenue() {
      this.isSubmitting = true;
      this.message = '';
      
      try {
        // Basic validation
        if (!this.venue.name || !this.venue.address || !this.venue.city || !this.venue.country) {
          throw new Error('Please fill in all required fields');
        }

        if (this.venue.venue_type === 'other' && !this.venue.custom_venue_type) {
          throw new Error('Please specify the custom venue type');
        }

        const formData = new FormData();

        // Append all fields to formData
        for (const key in this.venue) {
          if (key === 'photo_gallery' && Array.isArray(this.venue.photo_gallery)) {
            // Handle photo gallery - append each file individually
            this.venue.photo_gallery.forEach((file, index) => {
              if (file instanceof File) {
                formData.append(`photo_gallery`, file);
              }
            });
          } else if (key === 'menu_file' && this.venue.menu_file) {
            // Handle single menu file
            if (this.venue.menu_file instanceof File) {
              formData.append('menu_file', this.venue.menu_file);
            }
          } else if (this.venue[key] !== null && this.venue[key] !== undefined && this.venue[key] !== '') {
            // Handle all other fields
            formData.append(key, this.venue[key]);
          }
        }

        // Debug: log what we're sending
        console.log('FormData contents:');
        for (let pair of formData.entries()) {
          console.log(pair[0], pair[1]);
        }

        const response = await this.$axios.post('/api/venues', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });

        this.message = 'Venue created successfully!';
        this.resetForm();
        
        // Optionally redirect or emit event
        // this.$router.push('/venues');
        // this.$emit('venue-created', response.data);
        
      } catch (error) {
        console.error('Error creating venue:', error);
        this.message = error.response?.data?.message || error.message || 'Error creating venue.';
      } finally {
        this.isSubmitting = false;
      }
    },
    
    resetForm() {
      this.venue = {
        name: '',
        address: '',
        city: '',
        state: '',
        country: '',
        zip_code: '',
        latitude: null,
        longitude: null,
        capacity: null,
        price_per_hour: null,
        venue_type: '',
        custom_venue_type: '',
        floor_area_sqft: null,
        layout_type: '',
        contact_email: '',
        contact_phone: '',
        video_tour_url: '',
        minimum_booking_hours: null,
        max_booking_hours: null,
        pricing_model: '',
        security_deposit: null,
        restrooms_available: false,
        air_conditioning: false,
        heating: false,
        security_staff: false,
        internet_access: false,
        status: 'pending',
        menu_file: null,
        available_from: '',
        available_to: '',
        owner_id: null,
        parking_available: false,
        wheelchair_accessible: false,
        kitchen_facilities: false,
        catering_available: false,
        sound_system: false,
        stage_available: false,
        outdoor_area: false,
        decor_services: false,
        lighting_options: '',
        seating_arrangement_options: '',
        photo_gallery: [],
        custom_rules: '',
        booking_policy: '',
        chairs: null,
        tables: null
      };
      this.showImageUploader = false;
      this.showFileUploader = false;
    }
  }
};
</script>