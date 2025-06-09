<template>
  <div class="p-6 bg-white rounded shadow-md max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Create Event</h1>
    <form @submit.prevent="submitEvent" class="space-y-4">
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

      <!-- Venue Selection with Details -->
      <div class="space-y-4">
        <label class="block">
          <span class="text-gray-700 font-semibold">Venue</span>
          <select 
            v-model="event.venue_id" 
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            required
            @change="loadVenueDetails"
          >
            <option disabled value="">Please select a venue</option>
            <option v-for="venue in venues" :key="venue.id" :value="venue.id">
              {{ venue.name }} - {{ venue.city }}
            </option>
          </select>
        </label>

        <!-- Venue Details Card -->
        <div v-if="selectedVenue" class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
          <h3 class="text-lg font-semibold mb-3 flex items-center">
            <i class="fas fa-building mr-2 text-blue-600"></i>
            {{ selectedVenue.name }}
          </h3>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Venue Capacity -->
            <div class="space-y-2">
              <h4 class="font-medium text-gray-700">Capacity</h4>
              <div class="text-sm text-gray-600">
                <p v-if="selectedVenue.min_capacity && selectedVenue.max_capacity">
                  {{ selectedVenue.min_capacity }} - {{ selectedVenue.max_capacity }} people
                </p>
                <p v-else-if="selectedVenue.max_capacity">
                  Up to {{ selectedVenue.max_capacity }} people
                </p>
                <p v-else>Capacity not specified</p>
              </div>
            </div>

            <!-- Venue Pricing -->
            <div class="space-y-2">
              <h4 class="font-medium text-gray-700">Pricing</h4>
              <div class="text-sm text-gray-600 space-y-1">
                <p v-if="selectedVenue.price_per_hour">
                  <i class="fas fa-clock text-blue-500 mr-1"></i>
                  {{ formatCurrency(selectedVenue.price_per_hour) }}/hour
                </p>
                <p v-if="selectedVenue.price_per_day">
                  <i class="fas fa-calendar-day text-blue-500 mr-1"></i>
                  {{ formatCurrency(selectedVenue.price_per_day) }}/day
                </p>
                <p v-if="selectedVenue.price_per_week">
                  <i class="fas fa-calendar-week text-blue-500 mr-1"></i>
                  {{ formatCurrency(selectedVenue.price_per_week) }}/week
                </p>
                <p v-if="selectedVenue.price_per_person">
                  <i class="fas fa-user-friends text-blue-500 mr-1"></i>
                  {{ formatCurrency(selectedVenue.price_per_person) }}/person
                </p>
                <p v-if="selectedVenue.per_event_price">
                  <i class="fas fa-ticket-alt text-blue-500 mr-1"></i>
                  {{ formatCurrency(selectedVenue.per_event_price) }} (flat rate)
                </p>
              </div>
            </div>
          </div>

          <!-- Venue Features -->
          <div v-if="selectedVenue.features && Object.keys(selectedVenue.features).length > 0" class="mt-4">
            <h4 class="font-medium text-gray-700 mb-2">Available Features</h4>
            <div class="flex flex-wrap gap-2">
              <span 
                v-for="(value, feature) in selectedVenue.features" 
                :key="feature"
                v-if="value && typeof value === 'boolean'"
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
              >
                <i v-if="featureIcons[feature]" :class="[featureIcons[feature], 'mr-1']"></i>
                {{ formatFeatureName(feature) }}
              </span>
              <span 
                v-else-if="value && typeof value === 'number' && value > 0"
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"
              >
                <i v-if="featureIcons[feature]" :class="[featureIcons[feature], 'mr-1']"></i>
                {{ value }}x {{ formatFeatureName(feature) }}
              </span>
            </div>
          </div>

          <!-- Venue Facilities -->
          <div v-if="selectedVenue.facilities && selectedVenue.facilities.length > 0" class="mt-4">
            <h4 class="font-medium text-gray-700 mb-2">Facilities</h4>
            <div class="flex flex-wrap gap-2">
              <span 
                v-for="facility in selectedVenue.facilities" 
                :key="facility"
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800"
              >
                <i v-if="featureIcons[facility]" :class="[featureIcons[facility], 'mr-1']"></i>
                {{ formatFeatureName(facility) }}
              </span>
            </div>
          </div>

          <!-- Additional Fees -->
          <div v-if="selectedVenue.additional_fees && selectedVenue.additional_fees.length > 0" class="mt-4">
            <h4 class="font-medium text-gray-700 mb-2">Additional Fees</h4>
            <ul class="text-sm text-gray-600 space-y-1">
              <li v-for="(fee, index) in selectedVenue.additional_fees" :key="index" class="flex justify-between">
                <span>{{ fee.name }}:</span>
                <span class="font-medium">{{ formatCurrency(fee.amount) }} {{ fee.type === 'per_guest' ? 'per guest' : fee.type === 'per_hour' ? 'per hour' : 'flat fee' }}</span>
              </li>
            </ul>
          </div>
        </div>
      </div>

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
            <!-- Venue selection is handled by the dropdown at the top -->
          </div>
        </div>
      </div>
    <!-- Venue Pricing Options -->
    <div v-if="event.venue_id" class="mt-4 p-4 bg-gray-50 rounded">
      <h3 class="text-lg font-semibold mb-4">Venue Pricing Options</h3>
      <div class="space-y-4">
        <label class="block">
          <span class="text-gray-700 font-semibold">Pricing Selection</span>
          <select v-model="event.venue_details.pricing_selection" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            <option value="hourly">Hourly Rate</option>
            <option value="daily">Daily Rate</option>
            <option value="weekly">Weekly Rate</option>
            <option value="monthly">Monthly Rate</option>
            <option value="per_person">Per Person</option>
            <option value="flat_rate">Flat Rate</option>
          </select>
        </label>
        <label class="block">
          <span class="text-gray-700 font-semibold">Estimated Total</span>
          <input 
            v-model="event.venue_details.estimated_total" 
            type="number" 
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
            readonly
          />
        </label>
        <label class="block">
          <span class="text-gray-700 font-semibold">Deposit Required</span>
          <input 
            v-model="event.venue_details.deposit_required" 
            type="number" 
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
            readonly
          />
        </label>
        <label class="block">
          <span class="text-gray-700 font-semibold">Final Payment Due</span>
          <input 
            v-model="event.venue_details.final_payment_due" 
            type="date" 
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
            readonly
          />
        </label>
      </div>
    </div>
      <!-- Submit and Reset Buttons -->
      <div class="flex justify-end space-x-4 mt-8">
        <button 
          type="button" 
          @click="resetForm"
          class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
        >
          Reset
        </button>
        <button 
          type="submit" 
          :disabled="loading"
          class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <span v-if="loading">
            <i class="fas fa-spinner fa-spin mr-2"></i> Creating...
          </span>
          <span v-else>Create Event</span>
        </button>
      </div>
      
      <!-- Message Display -->
      <div v-if="message" :class="['mt-4 p-4 rounded-md', messageType === 'error' ? 'bg-red-50 text-red-700' : 'bg-green-50 text-green-700']">
        <div class="flex">
          <div class="flex-shrink-0">
            <i :class="[messageType === 'error' ? 'fas fa-exclamation-circle' : 'fas fa-check-circle']"></i>
          </div>
          <div class="ml-3">
            <p class="text-sm">
              {{ message }}
            </p>
          </div>
        </div>
      </div>
      
      <!-- Loading Indicator -->
      <div v-if="loading" class="mt-4 p-4 bg-blue-50 rounded-md">
        <div class="flex">
          <div class="flex-shrink-0">
            <i class="fas fa-spinner fa-spin text-blue-500"></i>
          </div>
          <div class="ml-3">
            <p class="text-sm text-blue-700">
              Creating your event. Please wait...
            </p>
          </div>
        </div>
      </div>
    </form>
</div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'CreateEvent',
  data() {
    return {
      loadingVenue: false,
      message: '',
      messageType: '',
      venues: [],
      selectedVenue: null,
      pricingOptions: [],
      loading: false,
      featureIcons: {
        wheelchair_ramps: 'fas fa-wheelchair',
        microphones: 'fas fa-microphone',
        tables: 'fas fa-utensils',
        artwork: 'fas fa-palette',
        fire_extinguishers: 'fas fa-fire-extinguisher',
        air_conditioning: 'fas fa-snowflake',
        in_house_catering: 'fas fa-utensils',
        live_music: 'fas fa-music',
        swimming_pool: 'fas fa-swimming-pool',
        patio: 'fas fa-umbrella-beach',
        valet_parking: 'fas fa-parking',
        on_site_hotel: 'fas fa-hotel',
        printing: 'fas fa-print',
        event_coordinator: 'fas fa-user-tie',
        meditation_room: 'fas fa-spa',
        pet_friendly: 'fas fa-paw',
        luxury_concierge: 'fas fa-concierge-bell',
        organic_menu: 'fas fa-leaf',
        recycling_bins: 'fas fa-recycle'
      },
      eventTypeRequirements: {
        wedding: {
          required: ['bride_name', 'groom_name', 'ceremony_type', 'reception_type'],
          optional: ['wedding_planner', 'photographer', 'florist', 'caterer']
        },
        birthday: {
          required: ['birthday_person', 'age', 'theme'],
          optional: ['entertainment', 'cake_flavor', 'decorations']
        },
        corporate: {
          required: ['company_name', 'contact_person', 'attendee_count'],
          optional: ['av_requirements', 'catering_preferences', 'seating_style']
        },
        conference: {
          required: ['conference_name', 'expected_attendees', 'tracks'],
          optional: ['speakers', 'sponsors', 'workshops', 'recording_required']
        },
        workshop: {
          required: ['workshop_name', 'instructor', 'max_participants'],
          optional: ['materials_provided', 'certification', 'prerequisites']
        },
        concert: {
          required: ['artist_name', 'genre', 'duration'],
          optional: ['opening_act', 'merchandise', 'vip_packages']
        },
        exhibition: {
          required: ['exhibition_name', 'theme', 'organizer'],
          optional: ['booth_count', 'keynote_speakers', 'sponsors']
        },
        graduation: {
          required: ['graduate_name', 'institution', 'degree'],
          optional: ['valedictorian', 'guest_speaker', 'reception_details']
        },
        anniversary: {
          required: ['anniversary_type', 'couple_names', 'years_married'],
          optional: ['vow_renewal', 'theme', 'special_guests']
        },
        other: {
          required: ['event_purpose', 'target_audience'],
          optional: ['special_requirements', 'theme', 'activities']
        }
      },
      event: {
        name: '',
        description: '',
        event_type: '',
        start_date: '',
        start_time: '',
        end_date: '',
        end_time: '',
        venue_id: '',
        expected_attendees: 1,
        budget: 0,
        status: 'draft',
        catering_required: false,
        security_required: false,
        parking_required: false,
        entertainment_required: false,
        audio_visual_required: false,
        decoration_required: false,
        venue_details: {
          pricing_selection: 'hourly',
          estimated_total: 0,
          deposit_required: 0,
          final_payment_due: ''
        },
        event_type_specific_fields: {}
      }
    };
  },
  
  watch: {
    'event.venue_id': {
      handler: 'loadVenueDetails',
      immediate: true
    },
    'event.venue_details.pricing_selection': {
      handler: 'calculateEstimatedTotal',
      immediate: true
    },
    'event.start_date': {
      handler: 'calculateEstimatedTotal'
    },
    'event.end_date': {
      handler: 'calculateEstimatedTotal'
    },
    'event.expected_attendees': {
      handler: 'calculateEstimatedTotal'
    }
  },
  
  created() {
    this.updateEventTypeFields();
  },
  mounted() {
    this.fetchVenues();
  },
  
  methods: {
    async fetchVenues() {
      try {
        const response = await axios.get('/api/venues');
        this.venues = response.data;
      } catch (error) {
        console.error('Error fetching venues:', error);
        this.message = 'Failed to load venues. Please try again.';
        this.messageType = 'error';
      }
    },
    
    async submitEvent() {
      try {
        this.loading = true;
        const response = await axios.post('/api/events', this.event);
        this.message = 'Event created successfully!';
        this.messageType = 'success';
        // Reset form or redirect if needed
        this.$router.push(`/events/${response.data.id}`);
      } catch (error) {
        console.error('Error creating event:', error);
        this.message = error.response?.data?.message || 'Failed to create event. Please try again.';
        this.messageType = 'error';
      } finally {
        this.loading = false;
      }
    },
    
    updateEventTypeFields() {
      // Initialize event type specific fields if they don't exist
      if (!this.event.event_type_specific_fields) {
        this.event.event_type_specific_fields = {};
      }
      
      if (this.event.event_type && !this.event.event_type_specific_fields[this.event.event_type]) {
        // Initialize with empty strings for required fields
        const requiredFields = this.eventTypeRequirements[this.event.event_type]?.required || [];
        const initialFields = {};
        requiredFields.forEach(field => {
          initialFields[field] = '';
        });
        this.event.event_type_specific_fields[this.event.event_type] = initialFields;
      }
    },
    
    validateForm() {
      // Basic validation - can be expanded
      if (!this.event.name || !this.event.start_date || !this.event.end_date || !this.event.venue_id) {
        this.message = 'Please fill in all required fields';
        this.messageType = 'error';
        return false;
      }
      
      // Check if end date is after start date
      const start = new Date(`${this.event.start_date}T${this.event.start_time || '00:00'}`);
      const end = new Date(`${this.event.end_date}T${this.event.end_time || '23:59'}`);
      
      if (end <= start) {
        this.message = 'End date must be after start date';
        this.messageType = 'error';
        return false;
      }
      
      return true;
    },
    
    resetForm() {
      this.event = {
        name: '',
        description: '',
        event_type: '',
        start_date: '',
        start_time: '',
        end_date: '',
        end_time: '',
        venue_id: null,
        expected_attendees: 1,
        budget: 0,
        status: 'draft',
        catering_required: false,
        security_required: false,
        parking_required: false,
        entertainment_required: false,
        audio_visual_required: false,
        decoration_required: false,
        event_type_specific_fields: {}
      };
      this.selectedVenue = null;
      this.message = '';
      this.messageType = '';
    },
    // ... existing methods ...
    formatCurrency(amount) {
      if (!amount) return 'N/A';
      return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: this.selectedVenue?.currency || 'USD',
        minimumFractionDigits: 0,
        maximumFractionDigits: 2
      }).format(amount);
    },
    
    formatFeatureName(name) {
      if (!name) return '';
      // Convert snake_case to Title Case
      return name.split('_')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ');
    },
    
    async loadVenueDetails() {
      if (!this.event.venue_id) {
        this.selectedVenue = null;
        return;
      }
      
      this.loadingVenue = true;
      try {
        const response = await axios.get(`/api/venues/${this.event.venue_id}`);
        this.selectedVenue = response.data;
        this.updateEventPricingOptions();
      } catch (error) {
        console.error('Error loading venue details:', error);
        this.message = 'Failed to load venue details. Please try again.';
        this.messageType = 'error';
      } finally {
        this.loadingVenue = false;
      }
    },
    
    updateEventPricingOptions() {
      if (!this.selectedVenue) return;
      
      // Determine available pricing options based on venue
      const pricingOptions = [];
      if (this.selectedVenue.price_per_hour) pricingOptions.push({ value: 'hourly', label: 'Hourly Rate' });
      if (this.selectedVenue.price_per_day) pricingOptions.push({ value: 'daily', label: 'Daily Rate' });
      if (this.selectedVenue.price_per_week) pricingOptions.push({ value: 'weekly', label: 'Weekly Rate' });
      if (this.selectedVenue.price_per_month) pricingOptions.push({ value: 'monthly', label: 'Monthly Rate' });
      if (this.selectedVenue.price_per_person) pricingOptions.push({ value: 'per_person', label: 'Per Person' });
      if (this.selectedVenue.per_event_price) pricingOptions.push({ value: 'flat_rate', label: 'Flat Rate' });
      
      this.pricingOptions = pricingOptions;
      
      // Set default pricing selection if not already set
      if (pricingOptions.length > 0 && !this.event.venue_details.pricing_selection) {
        this.event.venue_details.pricing_selection = pricingOptions[0].value;
      }
      
      this.calculateEstimatedTotal();
    },
    
    calculateEstimatedTotal() {
      if (!this.selectedVenue) return 0;
      
      let basePrice = 0;
      const pricingType = this.event.venue_details.pricing_selection;
      
      // Calculate base price based on pricing type
      switch (pricingType) {
        case 'hourly':
          basePrice = this.selectedVenue.price_per_hour * this.calculateEventDuration('hours');
          break;
        case 'daily':
          basePrice = this.selectedVenue.price_per_day * this.calculateEventDuration('days');
          break;
        case 'weekly':
          basePrice = this.selectedVenue.price_per_week * this.calculateEventDuration('weeks');
          break;
        case 'monthly':
          basePrice = this.selectedVenue.price_per_month * this.calculateEventDuration('months');
          break;
        case 'per_person':
          basePrice = this.selectedVenue.price_per_person * this.event.expected_attendees;
          break;
        case 'flat_rate':
          basePrice = this.selectedVenue.per_event_price;
          break;
      }
      
      // Add additional fees
      let additionalFees = 0;
      if (this.selectedVenue.additional_fees) {
        this.selectedVenue.additional_fees.forEach(fee => {
          if (fee.type === 'per_guest') {
            additionalFees += fee.amount * this.event.expected_attendees;
          } else if (fee.type === 'per_hour') {
            additionalFees += fee.amount * this.calculateEventDuration('hours');
          } else {
            additionalFees += fee.amount; // Flat fee
          }
        });
      }
      
      // Calculate deposit if required
      let depositAmount = 0;
      if (this.selectedVenue.deposit_required) {
        if (this.selectedVenue.deposit_amount) {
          depositAmount = this.selectedVenue.deposit_amount;
        } else if (this.selectedVenue.deposit_percentage) {
          depositAmount = (basePrice + additionalFees) * (this.selectedVenue.deposit_percentage / 100);
        }
      }
      
      this.event.venue_details.estimated_total = basePrice + additionalFees;
      this.event.venue_details.deposit_required = depositAmount;
      
      // Set final payment due date (7 days before event)
      if (this.event.start_date) {
        const dueDate = new Date(this.event.start_date);
        dueDate.setDate(dueDate.getDate() - 7);
        this.event.venue_details.final_payment_due = dueDate.toISOString().split('T')[0];
      }
      
      return this.event.venue_details.estimated_total;
    },
    
    calculateEventDuration(unit = 'hours') {
      if (!this.event.start_date || !this.event.end_date || !this.event.start_time || !this.event.end_time) return 0;
      
      const start = new Date(`${this.event.start_date}T${this.event.start_time}`);
      const end = new Date(`${this.event.end_date}T${this.event.end_time}`);
      
      // Calculate difference in milliseconds
      const diffMs = end - start;
      
      // Convert to different units
      switch (unit) {
        case 'minutes':
          return Math.ceil(diffMs / (1000 * 60));
        case 'hours':
          return Math.ceil(diffMs / (1000 * 60 * 60));
        case 'days':
          return Math.ceil(diffMs / (1000 * 60 * 60 * 24));
        case 'weeks':
          return Math.ceil(diffMs / (1000 * 60 * 60 * 24 * 7));
        case 'months':
          return Math.ceil(diffMs / (1000 * 60 * 60 * 24 * 30)); // Approximate
        default:
          return diffMs;
      }
    },
    
    // ... existing methods ...
  }
}
</script>
