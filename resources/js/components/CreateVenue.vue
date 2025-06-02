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
      
      <!-- Venue Type -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Venue Type</span>
        <select 
          v-model="venue.venue_type" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          required
          @change="updateFacilityRequirements"
        >
          <option value="">Select venue type</option>
          <option v-for="type in venueTypes" :key="type.id" :value="type.name.toLowerCase().replace(/\s+/g, '_')">
            {{ type.name }}
          </option>
        </select>
      </label>

      <!-- Venue Type Requirements -->
      <div v-if="venue.venue_type" class="mt-4 p-4 bg-gray-50 rounded">
        <h3 class="text-lg font-semibold mb-4">Venue Requirements</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Required Facilities -->
          <div>
            <h4 class="text-gray-600 font-medium mb-2">Required Facilities</h4>
            <div class="space-y-2">
              <template v-for="facility in requiredFacilities[venue.venue_type]" :key="facility">
                <label class="flex items-center space-x-2">
                  <i :class="facilityIcons[facility]" class="fa-lg text-blue-600"></i>
                  <span class="text-gray-700">{{ facility.replace('_', ' ').replace(/\w+/g, (txt) => txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()) }}</span>
                </label>
              </template>
            </div>
          </div>

          <!-- Optional Facilities -->
          <div>
            <h4 class="text-gray-600 font-medium mb-2">Optional Facilities</h4>
            <div class="space-y-2">
              <template v-for="facility in optionalFacilities[venue.venue_type]" :key="facility">
                <label class="flex items-center space-x-2">
                  <input type="checkbox" v-model="venue.facilities" :value="facility" class="rounded" />
                  <i :class="facilityIcons[facility]" class="fa-lg text-blue-600"></i>
                  <span class="text-gray-700">{{ facility.replace('_', ' ').replace(/\w+/g, (txt) => txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()) }}</span>
                </label>
              </template>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Venue Subtype (only for specific types) -->
      <div v-if="venue.venue_type === 'conference_center'" class="mt-4">
        <label class="block">
          <span class="text-gray-700 font-semibold">Conference Type</span>
          <select 
            v-model="venue.venue_subtype" 
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            required
          >
            <option disabled value="">Please select</option>
            <option value="business">Business Conference</option>
            <option value="academic">Academic Conference</option>
            <option value="workshop">Workshop</option>
          </select>
        </label>
      </div>

      <!-- Banquet Hall Style -->
      <div v-if="venue.venue_type === 'banquet_hall'" class="mt-4">
        <label class="block">
          <span class="text-gray-700 font-semibold">Banquet Style</span>
          <select 
            v-model="venue.venue_subtype" 
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            required
          >
            <option disabled value="">Please select</option>
            <option value="traditional">Traditional</option>
            <option value="modern">Modern</option>
            <option value="outdoor">Outdoor</option>
          </select>
        </label>
      </div>

      <!-- Custom Venue Type -->
      <div v-if="venue.venue_type === 'other'" class="mt-4">
        <label class="block">
          <span class="text-gray-700 font-semibold">Custom Venue Type</span>
          <input 
            v-model="venue.custom_venue_type" 
            type="text" 
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
            required
          />
        </label>
      </div>
      
      <!-- Venue Subtype (only for specific types) -->
      <label v-if="venue.venue_type === 'conference_center'" class="block">
        <span class="text-gray-700 font-semibold">Conference Type</span>
        <select 
          v-model="venue.venue_subtype" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          required
        >
          <option disabled value="">Please select</option>
          <option value="business">Business Conference</option>
          <option value="academic">Academic Conference</option>
          <option value="workshop">Workshop</option>
        </select>
      </label>

      <!-- Venue Subtype for Banquet Hall -->
      <label v-if="venue.venue_type === 'banquet_hall'" class="block">
        <span class="text-gray-700 font-semibold">Banquet Style</span>
        <select 
          v-model="venue.venue_subtype" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          required
        >
          <option disabled value="">Please select</option>
          <option value="traditional">Traditional</option>
          <option value="modern">Modern</option>
          <option value="outdoor">Outdoor</option>
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

      <!-- Facilities -->
      <div class="space-y-2">
        <span class="text-gray-700 font-semibold">Facilities</span>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
          <!-- Required facilities based on venue type -->
          <template v-for="facility in getRequiredFacilities" :key="facility">
            <label class="flex items-center space-x-2">
              <input 
                type="checkbox" 
                v-model="venue.facilities[facility]" 
                class="rounded" 
                :required="true"
              />
              <span class="text-gray-700">{{ facility.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) }}</span>
            </label>
          </template>

          <!-- Optional facilities -->
          <template v-for="facility in getOptionalFacilities" :key="facility">
            <label class="flex items-center space-x-2">
              <input 
                type="checkbox" 
                v-model="venue.facilities[facility]" 
                class="rounded"
              />
              <span class="text-gray-700">{{ facility.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) }}</span>
            </label>
          </template>
        </div>
      </div>

      <!-- Pricing Model input -->
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
        latitude: '',
        longitude: '',
        capacity: '',
        venue_type: '',
        available_from: '',
        available_until: '',
        booking_policy: '',
        facilities: [],
        images: [],
        floor_plan: null,
        amenities: [],
        available_days: [],
        price_per_hour: '',
        currency: 'USD',
        booking_notice_period: '',
        cancellation_policy: '',
        security_deposit: '',
        max_event_duration: '',
        setup_time: '',
        cleanup_time: '',
        special_requirements: '',
        contact_email: '',
        contact_phone: '',
        website_url: '',
        social_media_links: [],
        virtual_tour_url: '',
        video_url: '',
        status: 'active',
        
        // Facility-specific details
        catering_available: false,
        catering_capacity: null,
        catering_options: [],
        
        parking_available: false,
        parking_capacity: null,
        parking_type: '',
        
        wifi_available: false,
        wifi_speed: '',
        wifi_access_points: null,
        
        audio_visual_available: false,
        av_equipment: [],
        av_support: '',
        
        accessibility: false,
        
        outdoor_space: false,
        outdoor_area_size: null,
        outdoor_features: []
      },
      facilityIcons: {
        projector: 'fas fa-projector',
        sound_system: 'fas fa-volume-up',
        high_speed_internet: 'fas fa-wifi',
        meeting_rooms: 'fas fa-door-open',
        business_center: 'fas fa-briefcase',
        presentation_equipment: 'fas fa-desktop',
        catering: 'fas fa-utensils',
        dining_tables: 'fas fa-table',
        chairs: 'fas fa-chair',
        stage: 'fas fa-theater-masks',
        dance_floor: 'fas fa-dance',
        outdoor_space: 'fas fa-tree',
        weather_protection: 'fas fa-umbrella',
        garden: 'fas fa-leaf',
        patio: 'fas fa-sun',
        terrace: 'fas fa-umbrella-beach',
        deck: 'fas fa-deaf',
        gazebo: 'fas fa-umbrella',
        picnic_areas: 'fas fa-utensils',
        art_display: 'fas fa-paint-brush',
        security_cameras: 'fas fa-video',
        art_storage: 'fas fa-palette',
        gallery_space: 'fas fa-images',
        rooms: 'fas fa-bed',
        conference_facilities: 'fas fa-building',
        fitness_center: 'fas fa-dumbbell',
        spa: 'fas fa-bath',
        bar: 'fas fa-cocktail',
        kitchen: 'fas fa-utensils',
        wine_storage: 'fas fa-wine-glass',
        sports_facilities: 'fas fa-futbol',
        spectator_seating: 'fas fa-chairs',
        locker_rooms: 'fas fa-locker',
        scoreboard: 'fas fa-trophy',
        green_room: 'fas fa-door-open',
        backstage: 'fas fa-door-closed',
        dressing_rooms: 'fas fa-tshirt',
        loading_dock: 'fas fa-truck-loading',
        technical_booth: 'fas fa-tools',
        rehearsal_space: 'fas fa-music',
        gallery_shop: 'fas fa-store',
        educational_space: 'fas fa-chalkboard-teacher',
        event_space: 'fas fa-calendar-alt',
        vip_area: 'fas fa-crown',
        private_rooms: 'fas fa-door-closed',
        outdoor_seating: 'fas fa-umbrella-beach',
        live_music: 'fas fa-music',
        wine_bar: 'fas fa-wine-glass',
        cocktail_bar: 'fas fa-cocktail',
        vip_seating: 'fas fa-crown',
        training_facilities: 'fas fa-running',
        media_rooms: 'fas fa-video',
        team_lounges: 'fas fa-sofa',
        fan_shops: 'fas fa-store',
        storage: 'fas fa-box',
        security_system: 'fas fa-shield-alt',
        reception_area: 'fas fa-handshake',
        video_conferencing: 'fas fa-video',
        whiteboard: 'fas fa-chalkboard',
        flipchart: 'fas fa-chart-line',
        coffee_service: 'fas fa-coffee',
        printing_facilities: 'fas fa-print',
        breakout_rooms: 'fas fa-door-open',
        vip_area: 'fas fa-crown',
        bar_service: 'fas fa-cocktail',
        loading_dock: 'fas fa-truck-loading',
        technical_booth: 'fas fa-tools',
        rehearsal_space: 'fas fa-music',
        gallery_shop: 'fas fa-store',
        educational_space: 'fas fa-chalkboard-teacher',
        event_space: 'fas fa-calendar-alt',
        private_rooms: 'fas fa-door-closed',
        outdoor_seating: 'fas fa-umbrella-beach',
        live_music: 'fas fa-music',
        wine_bar: 'fas fa-wine-glass',
        cocktail_bar: 'fas fa-cocktail',
        vip_seating: 'fas fa-crown',
        training_facilities: 'fas fa-running',
        media_rooms: 'fas fa-video',
        team_lounges: 'fas fa-sofa',
        fan_shops: 'fas fa-store',
        storage: 'fas fa-box',
        security_system: 'fas fa-shield-alt',
        reception_area: 'fas fa-handshake'
      },
      message: '',
      success: false,
      requiredFacilities: {
        conference_hall: [
          'projector', 'sound_system', 'high_speed_internet',
          'meeting_rooms', 'business_center', 'presentation_equipment'
        ],
        banquet_hall: [
          'catering', 'dining_tables', 'chairs',
          'stage', 'sound_system', 'dance_floor'
        ],
        outdoor: [
          'outdoor_space', 'weather_protection',
          'garden', 'patio', 'terrace'
        ],
        theater: [
          'stage', 'sound_system', 'lighting',
          'backstage', 'green_room', 'dressing_rooms'
        ],
        gallery: [
          'art_display', 'security_cameras',
          'art_storage', 'gallery_space'
        ],
        hotel: [
          'rooms', 'catering', 'parking',
          'conference_facilities', 'fitness_center', 'spa'
        ],
        restaurant: [
          'catering', 'dining_tables', 'chairs',
          'bar', 'kitchen', 'wine_storage'
        ],
        sports_venue: [
          'sports_facilities', 'spectator_seating',
          'locker_rooms', 'scoreboard', 'sound_system'
        ],
        exhibition_hall: [
          'exhibition_space', 'lighting',
          'security_cameras', 'loading_dock', 'storage'
        ],
        other: []
      },
      optionalFacilities: {
        conference_hall: [
          'video_conferencing', 'whiteboard', 'flipchart',
          'breakout_rooms', 'coffee_service', 'printing_facilities'
        ],
        banquet_hall: [
          'vip_area', 'dance_floor', 'stage',
          'sound_system', 'lighting', 'bar_service'
        ],
        outdoor: [
          'garden', 'patio', 'terrace',
          'deck', 'gazebo', 'picnic_areas'
        ],
        theater: [
          'green_room', 'backstage', 'dressing_rooms',
          'loading_dock', 'technical_booth', 'rehearsal_space'
        ],
        gallery: [
          'art_storage', 'security_system',
          'gallery_shop', 'educational_space', 'event_space'
        ],
        hotel: [
          'conference_facilities', 'spa', 'gym',
          'swimming_pool', 'restaurant', 'bar'
        ],
        restaurant: [
          'private_rooms', 'outdoor_seating',
          'live_music', 'wine_bar', 'cocktail_bar'
        ],
        sports_venue: [
          'vip_seating', 'training_facilities',
          'media_rooms', 'team_lounges', 'fan_shops'
        ],
        exhibition_hall: [
          'loading_dock', 'storage', 'security_system',
          'technical_booth', 'reception_area', 'meeting_rooms'
        ],
        other: []
      },
      venueTypes: [
        { id: 1, name: 'Conference Hall', facilities: ['projector', 'sound_system', 'high_speed_internet'] },
        { id: 2, name: 'Banquet Hall', facilities: ['catering', 'dining_tables', 'chairs'] },
        { id: 3, name: 'Outdoor Venue', facilities: ['outdoor_space', 'weather_protection'] },
        { id: 4, name: 'Theater', facilities: ['stage', 'sound_system', 'lighting'] },
        { id: 5, name: 'Gallery', facilities: ['art_display', 'security_cameras'] },
        { id: 6, name: 'Hotel', facilities: ['rooms', 'catering', 'parking'] },
        { id: 7, name: 'Restaurant', facilities: ['catering', 'dining_tables', 'chairs'] },
        { id: 8, name: 'Sports Venue', facilities: ['sports_facilities', 'spectator_seating'] },
        { id: 9, name: 'Exhibition Hall', facilities: ['exhibition_space', 'lighting'] },
        { id: 10, name: 'Other', facilities: [] }
      ],
      images: [],
      floorPlan: null,
      amenities: [],
      availableDays: [],
      socialMediaLinks: [],
      currencyOptions: ['USD', 'EUR', 'GBP', 'AUD', 'CAD'],
      loading: false,
      venueTypeRequirements: {
        conference_hall: {
          required: ['capacity', 'rooms', 'catering', 'parking'],
          optional: ['conference_facilities', 'spa', 'gym', 'swimming_pool']
        },
        restaurant: {
          required: ['capacity', 'cuisine', 'menu_options', 'seating_arrangement'],
          optional: ['private_rooms', 'outdoor_seating', 'entertainment', 'bar']
        },
        outdoor: {
          required: ['capacity', 'location_type', 'weather_requirements'],
          optional: ['stage', 'sound_system', 'lighting', 'security']
        },
        gallery: {
          required: ['capacity', 'exhibition_space', 'lighting'],
          optional: ['workshop_space', 'refreshment_area', 'audio_visual']
        },
        theater: {
          required: ['capacity', 'stage', 'sound_system', 'lighting'],
          optional: ['dressing_rooms', 'green_room', 'parking', 'vip_seating']
        },
        sports_venue: {
          required: ['capacity', 'sport_type', 'facilities'],
          optional: ['parking', 'spectator_seating', 'refreshment_stands', 'lockers']
        },
        exhibition_hall: {
          required: ['capacity', 'exhibition_space', 'lighting', 'security'],
          optional: ['workshop_space', 'refreshment_area', 'audio_visual', 'storage']
        },
        other: {
          required: ['capacity', 'venue_description'],
          optional: []
        }
      },
      showImageUploader: false,
      showFileUploader: false
    };
  },
  computed: {
    // Get required facilities based on venue type
    getRequiredFacilities() {
      if (!this.venue.venue_type) return [];
      return this.venueTypeRequirements[this.venue.venue_type]?.required || [];
    },

    // Get optional facilities based on venue type
    getOptionalFacilities() {
      if (!this.venue.venue_type) return [];
      return this.venueTypeRequirements[this.venue.venue_type]?.optional || [];
    },
    messageClass() {
      return this.message.includes('Error') || this.message.includes('error')
        ? 'bg-red-100 text-red-700 border border-red-300'
        : 'bg-green-100 text-green-700 border border-green-300';
    }
  },
  methods: {
    // Update facility requirements based on venue type
    updateFacilityRequirements() {
      // Reset all facilities
      Object.keys(this.venue.facilities).forEach(facility => {
        this.venue.facilities[facility] = false;
      });

      // Set required facilities based on venue type
      const requirements = this.venueTypeRequirements[this.venue.venue_type];
      if (requirements) {
        requirements.required.forEach(facility => {
          this.venue.facilities[facility] = true;
        });
      }
    },
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