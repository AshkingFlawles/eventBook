<template>
  <div class="p-4 bg-gray-50 rounded">
    <h2 class="text-xl font-semibold mb-4">Pricing Details</h2>
    
    <!-- Currency Selector -->
    <div class="mb-4">
      <label class="block">
        <span class="text-gray-700 font-semibold">Currency</span>
        <select
          v-model="venue.currency"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
          required
        >
          <option value="USD">USD ($)</option>
          <option value="EUR">EUR (€)</option>
          <option value="GBP">GBP (£)</option>
          <option value="JPY">JPY (¥)</option>
          <option value="CAD">CAD (C$)</option>
          <option value="AUD">AUD (A$)</option>
        </select>
      </label>
    </div>
    <label class="block">
      <span class="text-gray-700 font-semibold">Pricing Model</span>
      <select
        v-model="venue.pricing_model"
        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
        required
      >
        <option disabled value="">Select Pricing Model</option>
        <option value="per_hour">Per Hour</option>
        <option value="per_day">Per Day</option>
        <option value="per_week">Per Week</option>
        <option value="per_month">Per Month</option>
        <option value="per_event">Per Event (Fixed Rate)</option>
        <option value="per_person">Per Person</option>
        <option value="tiered_hourly">Tiered Hourly (Time-based)</option>
        <option value="tiered_capacity">Tiered by Capacity</option>
        <option value="seasonal">Seasonal Pricing</option>
        <option value="dynamic">Dynamic Pricing</option>
        <option value="package">Package Pricing</option>
        <option value="membership">Membership Based</option>
        <option value="revenue_share">Revenue Share</option>
        <option value="negotiable">Negotiable</option>
        <option value="free">Free</option>
        <option value="flat_rate">Flat Rate</option>
        <option value="subscription">Subscription/Membership</option>
        <option value="tiered">Tiered Pricing</option>
      </select>
    </label>

    <!-- Per Hour Pricing -->
    <div v-if="venue.pricing_model === 'per_hour'" class="mt-4">
      <label class="block">
        <span class="text-gray-700 font-semibold">Price per Hour ({{ currencySymbol }})</span>
        <input
          v-model.number="venue.price_per_hour"
          type="number"
          step="0.01"
          min="0"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
          required
        />
      </label>
    </div>

    <!-- Per Day Pricing -->
    <div v-if="venue.pricing_model === 'per_day'" class="mt-4">
      <label class="block">
        <span class="text-gray-700 font-semibold">Price per Day ({{ currencySymbol }})</span>
        <input
          v-model.number="venue.price_per_day"
          type="number"
          step="0.01"
          min="0"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
          required
        />
      </label>
    </div>

    <!-- Per Week Pricing -->
    <div v-if="venue.pricing_model === 'per_week'" class="mt-4">
      <label class="block">
        <span class="text-gray-700 font-semibold">Price per Week ({{ currencySymbol }})</span>
        <input
          v-model.number="venue.price_per_week"
          type="number"
          step="0.01"
          min="0"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
          required
        />
      </label>
    </div>

    <!-- Per Month Pricing -->
    <div v-if="venue.pricing_model === 'per_month'" class="mt-4">
      <label class="block">
        <span class="text-gray-700 font-semibold">Price per Month ({{ currencySymbol }})</span>
        <input
          v-model.number="venue.price_per_month"
          type="number"
          step="0.01"
          min="0"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
          required
        />
      </label>
    </div>

    <!-- Per Event Pricing -->
    <div v-if="venue.pricing_model === 'per_event'" class="mt-4">
      <label class="block">
        <span class="text-gray-700 font-semibold">Fixed Rate ({{ currencySymbol }})</span>
        <input
          v-model.number="venue.per_event_price"
          type="number"
          step="0.01"
          min="0"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
          required
        />
      </label>
      <label class="block mt-2">
        <span class="text-gray-700 font-semibold">Description (optional)</span>
        <input
          v-model="venue.per_event_description"
          type="text"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
        />
      </label>
    </div>

    <!-- Per Person Pricing -->
    <div v-if="venue.pricing_model === 'per_person'" class="mt-4">
      <label class="block">
        <span class="text-gray-700 font-semibold">Price per Person ({{ currencySymbol }})</span>
        <input
          v-model.number="venue.price_per_person"
          type="number"
          step="0.01"
          min="0"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
          required
        />
      </label>
      <label class="block mt-2">
        <span class="text-gray-700 font-semibold">Minimum Guests</span>
        <input
          v-model.number="venue.min_guests"
          type="number"
          step="1"
          min="0"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
        />
      </label>
      <label class="block mt-2">
        <span class="text-gray-700 font-semibold">Maximum Guests</span>
        <input
          v-model.number="venue.max_guests"
          type="number"
          step="1"
          min="0"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
        />
      </label>
    </div>

    <!-- Tiered Hourly Pricing -->
    <div v-if="venue.pricing_model === 'tiered_hourly'" class="mt-4">
      <div v-for="(tier, index) in venue.pricing_tiers" :key="index" class="mb-4 p-4 border rounded">
        <label class="block">
          <span class="text-gray-700 font-semibold">Time Condition (e.g., 'Peak Hours 6-9 PM')</span>
          <input
            v-model="tier.condition"
            type="text"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            required
          />
        </label>
        <label class="block mt-2">
          <span class="text-gray-700 font-semibold">Rate ({{ currencySymbol }})</span>
          <input
            v-model.number="tier.rate"
            type="number"
            step="0.01"
            min="0"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            required
          />
        </label>
        <button type="button" @click="removeTier(index)" class="mt-2 text-red-600 hover:underline">
          Remove Tier
        </button>
      </div>
      <button type="button" @click="addTier" class="text-blue-600 hover:underline">Add Tier</button>
    </div>

    <!-- Tiered by Capacity Pricing -->
    <div v-if="venue.pricing_model === 'tiered_capacity'" class="mt-4">
      <div v-for="(tier, index) in venue.pricing_tiers" :key="index" class="mb-4 p-4 border rounded">
        <label class="block">
          <span class="text-gray-700 font-semibold">Capacity Condition (e.g., 'Up to 50 guests')</span>
          <input
            v-model="tier.condition"
            type="text"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            required
          />
        </label>
        <label class="block mt-2">
          <span class="text-gray-700 font-semibold">Rate ({{ currencySymbol }})</span>
          <input
            v-model.number="tier.rate"
            type="number"
            step="0.01"
            min="0"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            required
          />
        </label>
        <button type="button" @click="removeTier(index)" class="mt-2 text-red-600 hover:underline">
          Remove Tier
        </button>
      </div>
      <button type="button" @click="addTier" class="text-blue-600 hover:underline">Add Tier</button>
    </div>

    <!-- Seasonal Pricing -->
    <div v-if="venue.pricing_model === 'seasonal'" class="mt-4">
      <div v-for="(tier, index) in venue.pricing_tiers" :key="index" class="mb-4 p-4 border rounded">
        <label class="block">
          <span class="text-gray-700 font-semibold">Season (e.g., 'Summer')</span>
          <input
            v-model="tier.condition"
            type="text"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            required
          />
        </label>
        <label class="block mt-2">
          <span class="text-gray-700 font-semibold">Rate ({{ currencySymbol }})</span>
          <input
            v-model.number="tier.rate"
            type="number"
            step="0.01"
            min="0"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            required
          />
        </label>
        <button type="button" @click="removeTier(index)" class="mt-2 text-red-600 hover:underline">
          Remove Tier
        </button>
      </div>
      <button type="button" @click="addTier" class="text-blue-600 hover:underline">Add Tier</button>
    </div>

    <!-- Dynamic Pricing -->
    <div v-if="venue.pricing_model === 'dynamic'" class="mt-4">
      <p class="text-gray-700">Dynamic pricing varies based on demand. Managed externally.</p>
    </div>

    <!-- Package Pricing -->
    <div v-if="venue.pricing_model === 'package'" class="mt-4">
      <div v-for="(pkg, index) in venue.pricing_packages" :key="index" class="mb-4 p-4 border rounded">
        <label class="block">
          <span class="text-gray-700 font-semibold">Package Name</span>
          <input
            v-model="pkg.name"
            type="text"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            required
          />
        </label>
        <div class="mt-2">
          <span class="text-gray-700 font-semibold">Included Facilities</span>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-1">
            <label
              v-for="facility in allFacilitiesOptions"
              :key="facility"
              class="flex items-center space-x-2"
            >
              <input type="checkbox" v-model="pkg.facilities" :value="facility" class="rounded" />
              <i :class="facilityIcons[facility]" class="fa-lg text-blue-600"></i>
              <span class="text-gray-700">{{ formatFeatureName(facility) }}</span>
            </label>
          </div>
        </div>
        <label class="block mt-2">
          <span class="text-gray-700 font-semibold">Package Price ({{ currencySymbol }})</span>
          <input
            v-model.number="pkg.price"
            type="number"
            step="0.01"
            min="0"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            required
          />
        </label>
        <button type="button" @click="removePackage(index)" class="mt-2 text-red-600 hover:underline">
          Remove Package
        </button>
      </div>
      <button type="button" @click="addPackage" class="text-blue-600 hover:underline">Add Package</button>
    </div>

    <!-- Membership Based Pricing -->
    <div v-if="venue.pricing_model === 'membership'" class="mt-4">
      <div v-for="(plan, index) in venue.subscription_plans" :key="index" class="mb-4 p-4 border rounded">
        <label class="block">
          <span class="text-gray-700 font-semibold">Plan Name</span>
          <input
            v-model="plan.name"
            type="text"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            required
          />
        </label>
        <label class="block mt-2">
          <span class="text-gray-700 font-semibold">Price ({{ currencySymbol }})</span>
          <input
            v-model.number="plan.price"
            type="number"
            step="0.01"
            min="0"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            required
          />
        </label>
        <label class="block mt-2">
          <span class="text-gray-700 font-semibold">Billing Period</span>
          <select
            v-model="plan.billing_period"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            required
          >
            <option value="monthly">Monthly</option>
            <option value="quarterly">Quarterly</option>
            <option value="annually">Annually</option>
          </select>
        </label>
        <label class="block mt-2">
          <span class="text-gray-700 font-semibold">Included Benefits/Access</span>
          <textarea
            v-model="plan.benefits"
            rows="2"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            placeholder="e.g., 'Unlimited access, 10% discount on F&B'"
          ></textarea>
        </label>
        <button type="button" @click="removeSubscriptionPlan(index)" class="mt-2 text-red-600 hover:underline">
          Remove Plan
        </button>
      </div>
      <button type="button" @click="addSubscriptionPlan" class="text-blue-600 hover:underline">
        Add Subscription Plan
      </button>
    </div>

    <!-- Revenue Share Pricing -->
    <div v-if="venue.pricing_model === 'revenue_share'" class="mt-4">
      <label class="block">
        <span class="text-gray-700 font-semibold">Revenue Share Percentage (%)</span>
        <input
          v-model.number="venue.revenue_share_percentage"
          type="number"
          step="0.01"
          min="0"
          max="100"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
          required
        />
      </label>
      <label class="block mt-2">
        <span class="text-gray-700 font-semibold">Description</span>
        <textarea
          v-model="venue.revenue_share_description"
          rows="3"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
          placeholder="e.g., '20% of ticket sales'"
        ></textarea>
      </label>
    </div>

    <!-- Negotiable Pricing -->
    <div v-if="venue.pricing_model === 'negotiable'" class="mt-4">
      <p class="text-gray-700">Pricing is negotiable. Please contact us for details.</p>
      <label class="block mt-2">
        <span class="text-gray-700 font-semibold">Negotiation Notes</span>
        <textarea
          v-model="venue.negotiable_notes"
          rows="3"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
          placeholder="Any specific terms or conditions"
        ></textarea>
      </label>
    </div>

    <!-- Free Pricing -->
    <div v-if="venue.pricing_model === 'free'" class="mt-4">
      <p class="text-gray-700">This venue is free to use.</p>
    </div>

    <!-- Subscription Plans -->
    <div v-if="venue.pricing_model === 'subscription'" class="mt-4">
      <div v-for="(plan, index) in venue.subscription_plans" :key="'plan-'+index" class="mb-4 p-4 border rounded">
        <label class="block">
          <span class="text-gray-700 font-semibold">Plan Name</span>
          <input
            v-model="plan.name"
            type="text"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            required
          />
        </label>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
          <label class="block">
            <span class="text-gray-700 font-semibold">Price ({{ currencySymbol }})</span>
            <input
              v-model.number="plan.price"
              type="number"
              step="0.01"
              min="0"
              class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
              required
            />
          </label>
          <label class="block">
            <span class="text-gray-700 font-semibold">Billing Cycle</span>
            <select
              v-model="plan.billing_cycle"
              class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
              required
            >
              <option value="monthly">Monthly</option>
              <option value="quarterly">Quarterly</option>
              <option value="annually">Annually</option>
            </select>
          </label>
        </div>
        <label class="block mt-2">
          <span class="text-gray-700 font-semibold">Description</span>
          <textarea
            v-model="plan.description"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            rows="2"
          ></textarea>
        </label>
        <div class="flex justify-end">
          <button type="button" @click="removeSubscriptionPlan(index)" class="mt-2 text-red-600 hover:underline">
            Remove Plan
          </button>
        </div>
      </div>
      <button 
        type="button" 
        @click="addSubscriptionPlan" 
        class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
      >
        Add Subscription Plan
      </button>
    </div>

    <!-- Tiered Pricing -->
    <div v-if="venue.pricing_model === 'tiered'" class="mt-4">
      <div v-for="(tier, index) in venue.pricing_tiers" :key="'tier-'+index" class="mb-4 p-4 border rounded">
        <label class="block">
          <span class="text-gray-700 font-semibold">Tier Name</span>
          <input
            v-model="tier.name"
            type="text"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            placeholder="e.g., Basic, Premium, VIP"
            required
          />
        </label>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
          <label class="block">
            <span class="text-gray-700 font-semibold">Condition</span>
            <input
              v-model="tier.condition"
              type="text"
              class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
              placeholder="e.g., 'Weekdays 9-5', '50+ guests'"
              required
            />
          </label>
          <label class="block">
            <span class="text-gray-700 font-semibold">Rate ({{ currencySymbol }})</span>
            <input
              v-model.number="tier.rate"
              type="number"
              step="0.01"
              min="0"
              class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
              required
            />
          </label>
        </div>
        <div class="flex justify-end">
          <button 
            type="button" 
            @click="removeTier(index)" 
            class="mt-2 px-3 py-1 text-sm text-red-600 hover:bg-red-50 rounded border border-red-200 hover:border-red-300"
          >
            Remove Tier
          </button>
        </div>
      </div>
      <button 
        type="button" 
        @click="addTier" 
        class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
      >
        Add Tier
      </button>
    </div>

    <!-- Flat Rate Pricing -->
    <div v-if="venue.pricing_model === 'flat_rate'" class="mt-4">
      <label class="block">
        <span class="text-gray-700 font-semibold">Flat Rate Price ({{ currencySymbol }})</span>
        <input
          v-model.number="venue.flat_rate_price"
          type="number"
          step="0.01"
          min="0"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
          required
        />
      </label>
      <label class="block mt-2">
        <span class="text-gray-700 font-semibold">Description (e.g., 'for up to 4 hours')</span>
        <input
          v-model="venue.flat_rate_description"
          type="text"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
        />
      </label>
    </div>
  </div>
</template>

<script>
export default {
  name: 'VenuePricing',
  props: {
    venue: {
      type: Object,
      required: true,
      default: () => ({
        pricing_model: '',
        currency: 'USD',
        price_per_hour: null,
        price_per_day: null,
        price_per_week: null,
        price_per_month: null,
        per_event_price: null,
        price_per_person: null,
        min_guests: null,
        max_guests: null,
        pricing_tiers: [],
        pricing_packages: [],
        subscription_plans: [],
        deposit_required: false,
        deposit_amount: null,
        deposit_percentage: null,
        cancellation_policy: ''
      })
    },
    currencySymbol: {
      type: String,
      default: '$' // Default to $ if not provided
    },
    allFacilitiesOptions: {
      type: Array,
      default: () => []
    },
    facilityIcons: {
      type: Object,
      default: () => ({})
    },
    formatFeatureName: {
      type: Function,
      default: (name) => name
    },
    addTier: {
      type: Function,
      default: () => {}
    },
    removeTier: {
      type: Function,
      default: () => {}
    },
    addPackage: {
      type: Function,
      default: () => {}
    },
    removePackage: {
      type: Function,
      default: () => {}
    },
    addSubscriptionPlan: {
      type: Function,
      default: () => {}
    },
    removeSubscriptionPlan: {
      type: Function,
      default: () => {}
    }
  },
  watch: {
    'venue.currency'(newVal, oldVal) {
      if (newVal !== oldVal) {
        // Emit event to parent if needed
        this.$emit('update:currency', newVal);
      }
    }
  },
  methods: {
    // Add any component-specific methods here
    updateCurrency(event) {
      this.$emit('update:currency', event.target.value);
    }
  }
}
</script>
