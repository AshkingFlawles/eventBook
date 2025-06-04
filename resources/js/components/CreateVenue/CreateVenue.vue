<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Create New Venue</h1>
    <form @submit.prevent="submitVenue" class="space-y-6">
      <!-- Basic Information Component -->
      <BasicInformation
        :venue="venue"
        :venueTypeOptions="Object.keys(venueRequirements)"
        :availableCurrencies="availableCurrencies"
        @update-facilities="updateFacilities"
      />

      <!-- Venue Facilities Component -->
      <VenueFacilities
        :venue="venue"
        :requiredFacilities="requiredFacilities"
        :optionalFacilities="optionalFacilities"
        :facilityIcons="facilityIcons"
        :formatFeatureName="formatFeatureName"
      />

      <!-- Venue Pricing Component -->
      <VenuePricing
        :venue="venue"
        :currencySymbol="currencySymbol"
        :allFacilitiesOptions="allFacilitiesOptions"
        :facilityIcons="facilityIcons"
        :formatFeatureName="formatFeatureName"
        :addTier="addTier"
        :removeTier="removeTier"
        :addPackage="addPackage"
        :removePackage="removePackage"
        :addSubscriptionPlan="addSubscriptionPlan"
        :removeSubscriptionPlan="removeSubscriptionPlan"
      />

      <!-- Additional Fees Component -->
      <AdditionalFees
        :venue="venue"
        :currencySymbol="currencySymbol"
        @add-fee="addFee"
        @remove-fee="removeFee"
      />

      <!-- Additional Features Component -->
      <AdditionalFeatures
        :venue="venue"
        :showAdditionalFeatures="showAdditionalFeatures"
        :featureCategories="featureCategories"
        :formatFeatureName="formatFeatureName"
        v-model:showAdditionalFeatures="showAdditionalFeatures"
      />

      <!-- Submit Button -->
      <button type="submit" class="mt-6 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Create Venue
      </button>
    </form>
  </div>
</template>

<script>
import BasicInformation from './BasicInformation.vue';
import VenueFacilities from './VenueFacilities.vue';
import VenuePricing from './VenuePricing.vue';
import AdditionalFees from './AdditionalFees.vue';
import AdditionalFeatures from './AdditionalFeatures.vue';

export default {
  name: 'CreateVenue',
  components: {
    BasicInformation,
    VenueFacilities,
    VenuePricing,
    AdditionalFees,
    AdditionalFeatures,
  },
  data() {
    return {
      venue: {
        name: '',
        type: '',
        currency: 'USD',
        facilities: [],
        pricing_model: '',
        price_per_hour: null,
        price_per_day: null,
        price_per_week: null,
        price_per_month: null,
        per_event_price: null,
        per_event_description: '',
        price_per_person: null,
        min_guests: null,
        max_guests: null,
        pricing_tiers: [],
        pricing_packages: [],
        subscription_plans: [],
        deposit_required: false,
        deposit_amount: null,
        deposit_percentage: null,
        cancellation_policy: '',
        additional_fees: [],
        // Additional Features
        wheelchair_ramps: false, elevators: false, accessible_restrooms: false, braille_signage: false, hearing_assistance: false, service_animal_areas: false,
        microphones: 0, speakers: 0, projectors: 0, screens: 0, lighting_controls: false, av_control_room: false, streaming_equipment: false,
        tables: 0, chairs: 0, podiums: 0, lecterns: 0, coat_racks: 0, modular_furniture: 0, lounge_chairs: 0,
        artwork: false, plants: false, lighting_fixtures: false, banners: false, table_centerpieces: false, sculptures: false, themed_decor: false,
        fire_extinguishers: 0, emergency_exits: 0, first_aid_kits: 0, security_cameras: 0, alarm_system: false, defibrillators: 0,
        air_conditioning: false, heating: false, ventilation: false, humidity_control: false, solar_panels: false, noise_reduction: false,
        in_house_catering: false, external_catering_allowed: false, bar_service: false, coffee_stations: 0, water_dispensers: 0, buffet_setup: false,
        live_music: false, dj_booth: false, karaoke: false, dance_floor: false, stage: false, photo_booth: false, virtual_reality: false,
        swimming_pool: false, gym: false, spa: false, tennis_court: false, golf_course: false, arcade_games: 0, bowling_lanes: 0,
        patio: false, terrace: false, garden: false, pool: false, bbq_area: false, fire_pit: false, rooftop_access: false,
        valet_parking: false, self_parking: false, parking_garage: false, shuttle_service: false, taxi_stand: false, bike_sharing: false, ev_charging: 0,
        on_site_hotel: false, nearby_hotels: 0, vip_suites: 0,
        printing: false, copying: false, fax: false, business_center: false, high_speed_internet: false, conference_call_system: false,
        event_coordinator: false, staff: 0, security: false, cleaning_crew: 0,
        meditation_room: false, prayer_room: false, cultural_artifacts: false,
        pet_friendly: false, child_care: false, nursing_room: false,
        luxury_concierge: false, personal_shoppers: false, spa_services: false,
        interactive_screens: false, augmented_reality: false, holograms: false,
        organic_menu: false, vegan_options: false, allergen_free: false,
        recycling_bins: 0, composting: false, rainwater_harvesting: false,
      },
      showAdditionalFeatures: false,
      venueRequirements: {
        cafe: { required: ['tables', 'chairs', 'restrooms', 'coffee_machine'], optional: ['wifi', 'outdoor_seating', 'pastry_display', 'cash_register', 'barista_station', 'music_system'] },
        restaurant: { required: ['tables', 'chairs', 'kitchen', 'restrooms'], optional: ['bar', 'private_dining_rooms', 'outdoor_seating', 'wine_cellar', 'live_music_stage', 'valet_parking'] },
        open_space: { required: ['open_area'], optional: ['stage', 'sound_system', 'lighting', 'tents', 'portable_toilets', 'power_generators', 'seating'] },
        hall: { required: ['stage', 'seating', 'sound_system'], optional: ['projector', 'lighting', 'wifi', 'catering_kitchen', 'green_room', 'dressing_rooms'] },
        wedding_marquee: { required: ['tent', 'flooring', 'lighting'], optional: ['heating', 'cooling', 'dance_floor', 'bar', 'decorations', 'bridal_suite'] },
        conference_room: { required: ['projector', 'whiteboard', 'seating'], optional: ['video_conferencing', 'wifi', 'coffee_machine', 'flip_charts', 'sound_system', 'smart_board'] },
        event_center: { required: ['stage', 'sound_system', 'seating'], optional: ['lighting', 'green_room', 'catering_kitchen', 'multiple_breakout_rooms', 'valet_parking', 'exhibit_space'] },
        rooftop: { required: ['safety_rails', 'open_area'], optional: ['bar', 'lounge_area', 'lighting', 'sound_system', 'elevator_access', 'hot_tubs'] },
        theater: { required: ['stage', 'seating', 'sound_system', 'lighting'], optional: ['orchestra_pit', 'projector', 'dressing_rooms', 'fly_system', 'box_office'] },
        gallery: { required: ['display_walls', 'lighting'], optional: ['reception_area', 'storage', 'security_system', 'workshop_space', 'gift_shop', 'audio_guides'] },
        sports_arena: { required: ['playing_field', 'seating'], optional: ['scoreboard', 'locker_rooms', 'concession_stands', 'vip_boxes', 'press_box', 'jumbo_tron'] },
        park: { required: ['green_space'], optional: ['picnic_tables', 'restrooms', 'playground', 'walking_trails', 'bike_paths', 'amphitheater'] },
        beach: { required: ['sand', 'water_access'], optional: ['lifeguard', 'beach_chairs', 'umbrellas', 'volleyball_courts', 'shower_facilities', 'snack_bar'] },
        warehouse: { required: ['large_open_space'], optional: ['loading_dock', 'lighting', 'sound_system', 'temporary_walls', 'restrooms', 'climate_control'] },
        studio: { required: ['soundproofing', 'recording_equipment'], optional: ['green_screen', 'editing_suite', 'lighting_rigs', 'control_room', 'live_streaming'] },
        garden: { required: ['plants', 'pathways'], optional: ['water_features', 'seating', 'lighting', 'gazebos', 'sculptures', 'event_lawn'] },
        ballroom: { required: ['dance_floor', 'sound_system'], optional: ['chandelier', 'stage', 'bar', 'vip_area', 'coat_check', 'orchestral_space'] },
        auditorium: { required: ['stage', 'seating', 'sound_system'], optional: ['projector', 'lighting', 'backstage_area', 'orchestra_pit', 'acoustics_panels'] },
        nightclub: { required: ['dance_floor', 'sound_system', 'lighting'], optional: ['vip_area', 'bar', 'dj_booth', 'smoking_area', 'laser_show'] },
        bar: { required: ['bar_counter', 'seating'], optional: ['sound_system', 'dance_floor', 'pool_tables', 'dart_boards', 'outdoor_patio', 'cocktail_lounge'] },
        lounge: { required: ['comfortable_seating'], optional: ['bar', 'entertainment_system', 'fireplace', 'bookshelves', 'board_games', 'ambient_lighting'] },
        museum: { required: ['exhibit_space', 'security'], optional: ['cafe', 'gift_shop', 'auditorium', 'interactive_displays', 'restoration_lab'] },
        library: { required: ['bookshelves', 'reading_areas'], optional: ['wifi', 'meeting_rooms', 'computer_stations', 'children_area', 'study_carrels'] },
        coworking_space: { required: ['desks', 'wifi'], optional: ['meeting_rooms', 'printers', 'coffee_stations', 'lounge_area', 'phone_booths'] },
        amusement_park: { required: ['rides', 'ticketing'], optional: ['food_courts', 'restrooms', 'first_aid_station', 'arcade_games', 'water_park'] },
        ski_resort: { required: ['slopes', 'lifts'], optional: ['lodge', 'ski_rentals', 'warming_huts', 'snow_machines', 'apres_ski_bar'] },
        vineyard: { required: ['vineyard', 'tasting_room'], optional: ['barrel_room', 'outdoor_seating', 'event_space', 'wine_cellar', 'picnic_area'] },
      },
      facilityIcons: {
        tables: 'fas fa-table', chairs: 'fas fa-chair', restrooms: 'fas fa-restroom', coffee_machine: 'fas fa-coffee', kitchen: 'fas fa-utensils',
        wifi: 'fas fa-wifi', outdoor_seating: 'fas fa-umbrella-beach', pastry_display: 'fas fa-birthday-cake', cash_register: 'fas fa-cash-register',
        barista_station: 'fas fa-mug-hot', music_system: 'fas fa-music', bar: 'fas fa-glass-martini', private_dining_rooms: 'fas fa-door-closed',
        wine_cellar: 'fas fa-wine-bottle', live_music_stage: 'fas fa-microphone', valet_parking: 'fas fa-car', open_area: 'fas fa-expand',
        stage: 'fas fa-microphone', sound_system: 'fas fa-volume-up', lighting: 'fas fa-lightbulb', tents: 'fas fa-campground', portable_toilets: 'fas fa-toilet',
        power_generators: 'fas fa-bolt', seating: 'fas fa-chair', projector: 'fas fa-projector', catering_kitchen: 'fas fa-utensils', green_room: 'fas fa-door-closed',
        dressing_rooms: 'fas fa-tshirt', flooring: 'fas fa-shapes', heating: 'fas fa-temperature-high', cooling: 'fas fa-snowflake', dance_floor: 'fas fa-shoe-prints',
        decorations: 'fas fa-paint-brush', bridal_suite: 'fas fa-bed', whiteboard: 'fas fa-chalkboard', video_conferencing: 'fas fa-video', flip_charts: 'fas fa-clipboard',
        smart_board: 'fas fa-desktop', multiple_breakout_rooms: 'fas fa-door-open', exhibit_space: 'fas fa-image', safety_rails: 'fas fa-shield-alt',
        lounge_area: 'fas fa-couch', elevator_access: 'fas fa-elevator', hot_tubs: 'fas fa-hot-tub', orchestra_pit: 'fas fa-music', fly_system: 'fas fa-theater-masks',
        box_office: 'fas fa-ticket-alt', display_walls: 'fas fa-image', reception_area: 'fas fa-concierge-bell', storage: 'fas fa-box', security_system: 'fas fa-shield-alt',
        workshop_space: 'fas fa-tools', gift_shop: 'fas fa-shopping-bag', audio_guides: 'fas fa-headphones', playing_field: 'fas fa-futbol', scoreboard: 'fas fa-tally',
        locker_rooms: 'fas fa-lock', concession_stands: 'fas fa-popcorn', vip_boxes: 'fas fa-crown', press_box: 'fas fa-newspaper', jumbo_tron: 'fas fa-tv',
        picnic_tables: 'fas fa-utensils', playground: 'fas fa-child', walking_trails: 'fas fa-hiking', bike_paths: 'fas fa-bicycle', amphitheater: 'fas fa-theater-masks',
        lifeguard: 'fas fa-life-ring', beach_chairs: 'fas fa-chair', umbrellas: 'fas fa-umbrella', volleyball_courts: 'fas fa-volleyball-ball', shower_facilities: 'fas fa-shower',
        snack_bar: 'fas fa-hamburger', large_open_space: 'fas fa-expand', loading_dock: 'fas fa-truck-loading', temporary_walls: 'fas fa-wall-brick', climate_control: 'fas fa-fan',
        soundproofing: 'fas fa-volume-mute', recording_equipment: 'fas fa-microphone-alt', green_screen: 'fas fa-film', editing_suite: 'fas fa-edit', live_streaming: 'fas fa-broadcast-tower',
        plants: 'fas fa-leaf', pathways: 'fas fa-route', water_features: 'fas fa-water', gazebos: 'fas fa-umbrella', sculptures: 'fas fa-monument', event_lawn: 'fas fa-grass',
        chandelier: 'fas fa-lightbulb', vip_area: 'fas fa-crown', coat_check: 'fas fa-coat', orchestral_space: 'fas fa-violin', backstage_area: 'fas fa-door-closed',
        acoustics_panels: 'fas fa-wave-square', dj_booth: 'fas fa-headphones', smoking_area: 'fas fa-smoking', laser_show: 'fas fa-lightbulb', bar_counter: 'fas fa-glass-martini',
        pool_tables: 'fas fa-billiards', dart_boards: 'fas fa-bullseye', cocktail_lounge: 'fas fa-cocktail', comfortable_seating: 'fas fa-couch', entertainment_system: 'fas fa-tv',
        fireplace: 'fas fa-fire', bookshelves: 'fas fa-book', board_games: 'fas fa-chess', ambient_lighting: 'fas fa-lightbulb', cafe: 'fas fa-coffee', interactive_displays: 'fas fa-hand-pointer',
        restoration_lab: 'fas fa-tools', meeting_rooms: 'fas fa-door-open', computer_stations: 'fas fa-desktop', children_area: 'fas fa-child', study_carrels: 'fas fa-book-reader',
        desks: 'fas fa-desk', printers: 'fas fa-print', phone_booths: 'fas fa-phone', rides: 'fas fa-roller-coaster', ticketing: 'fas fa-ticket-alt', food_courts: 'fas fa-utensils',
        first_aid_station: 'fas fa-first-aid', arcade_games: 'fas fa-gamepad', water_park: 'fas fa-swimming-pool', slopes: 'fas fa-skiing', lifts: 'fas fa-chair-lift',
        lodge: 'fas fa-hotel', ski_rentals: 'fas fa-skiing-nordic', warming_huts: 'fas fa-fire', snow_machines: 'fas fa-snowflake', apres_ski_bar: 'fas fa-glass-cheers',
        vineyard: 'fas fa-wine-bottle', tasting_room: 'fas fa-glass-wine', barrel_room: 'fas fa-wine-bottle', picnic_area: 'fas fa-utensils',
      },
      featureCategories: [
        { name: 'Accessibility Features', features: [
          { name: 'wheelchair_ramps', type: 'checkbox', icon: 'fas fa-wheelchair' },
          { name: 'elevators', type: 'checkbox', icon: 'fas fa-elevator' },
          { name: 'accessible_restrooms', type: 'checkbox', icon: 'fas fa-restroom' },
          { name: 'braille_signage', type: 'checkbox', icon: 'fas fa-braille' },
          { name: 'hearing_assistance', type: 'checkbox', icon: 'fas fa-deaf' },
          { name: 'service_animal_areas', type: 'checkbox', icon: 'fas fa-dog' },
        ]},
        { name: 'Technical Equipment', features: [
          { name: 'microphones', type: 'number', icon: 'fas fa-microphone' },
          { name: 'speakers', type: 'number', icon: 'fas fa-volume-up' },
          { name: 'projectors', type: 'number', icon: 'fas fa-projector' },
          { name: 'screens', type: 'number', icon: 'fas fa-desktop' },
          { name: 'lighting_controls', type: 'checkbox', icon: 'fas fa-lightbulb' },
          { name: 'av_control_room', type: 'checkbox', icon: 'fas fa-sliders-h' },
          { name: 'streaming_equipment', type: 'checkbox', icon: 'fas fa-broadcast-tower' },
        ]},
        { name: 'Furniture', features: [
          { name: 'tables', type: 'number', icon: 'fas fa-table' },
          { name: 'chairs', type: 'number', icon: 'fas fa-chair' },
          { name: 'podiums', type: 'number', icon: 'fas fa-podium' },
          { name: 'lecterns', type: 'number', icon: 'fas fa-book-reader' },
          { name: 'coat_racks', type: 'number', icon: 'fas fa-coat' },
          { name: 'modular_furniture', type: 'number', icon: 'fas fa-cubes' },
          { name: 'lounge_chairs', type: 'number', icon: 'fas fa-couch' },
        ]},
        { name: 'Decorations', features: [
          { name: 'artwork', type: 'checkbox', icon: 'fas fa-paint-brush' },
          { name: 'plants', type: 'checkbox', icon: 'fas fa-leaf' },
          { name: 'lighting_fixtures', type: 'checkbox', icon: 'fas fa-lightbulb' },
          { name: 'banners', type: 'checkbox', icon: 'fas fa-flag' },
          { name: 'table_centerpieces', type: 'checkbox', icon: 'fas fa-flower' },
          { name: 'sculptures', type: 'checkbox', icon: 'fas fa-monument' },
          { name: 'themed_decor', type: 'checkbox', icon: 'fas fa-mask' },
        ]},
        { name: 'Safety Features', features: [
          { name: 'fire_extinguishers', type: 'number', icon: 'fas fa-fire-extinguisher' },
          { name: 'emergency_exits', type: 'number', icon: 'fas fa-door-open' },
          { name: 'first_aid_kits', type: 'number', icon: 'fas fa-first-aid' },
          { name: 'security_cameras', type: 'number', icon: 'fas fa-camera' },
          { name: 'alarm_system', type: 'checkbox', icon: 'fas fa-bell' },
          { name: 'defibrillators', type: 'number', icon: 'fas fa-heartbeat' },
        ]},
        { name: 'Environmental Controls', features: [
          { name: 'air_conditioning', type: 'checkbox', icon: 'fas fa-snowflake' },
          { name: 'heating', type: 'checkbox', icon: 'fas fa-temperature-high' },
          { name: 'ventilation', type: 'checkbox', icon: 'fas fa-fan' },
          { name: 'humidity_control', type: 'checkbox', icon: 'fas fa-tint' },
          { name: 'solar_panels', type: 'checkbox', icon: 'fas fa-solar-panel' },
          { name: 'noise_reduction', type: 'checkbox', icon: 'fas fa-volume-mute' },
        ]},
        { name: 'Catering and Beverage Services', features: [
          { name: 'in_house_catering', type: 'checkbox', icon: 'fas fa-utensils' },
          { name: 'external_catering_allowed', type: 'checkbox', icon: 'fas fa-truck' },
          { name: 'bar_service', type: 'checkbox', icon: 'fas fa-glass-martini' },
          { name: 'coffee_stations', type: 'number', icon: 'fas fa-coffee' },
          { name: 'water_dispensers', type: 'number', icon: 'fas fa-water' },
          { name: 'buffet_setup', type: 'checkbox', icon: 'fas fa-hamburger' },
        ]},
        { name: 'Entertainment Options', features: [
          { name: 'live_music', type: 'checkbox' , icon: 'fas fa-music' },
          { name: 'dj_booth', type: 'checkbox', icon: 'fas fa-headphones' },
          { name: 'karaoke', type: 'checkbox', icon: 'fas fa-microphone' },
          { name: 'dance_floor', type: 'checkbox', icon: 'fas fa-shoe-prints' },
          { name: 'stage', type: 'checkbox', icon: 'fas fa-microphone' },
          { name: 'photo_booth', type: 'checkbox', icon: 'fas fa-camera' },
          { name: 'virtual_reality', type: 'checkbox', icon: 'fas fa-vr-cardboard' },
        ]},
        { name: 'Recreational Facilities', features: [
          { name: 'swimming_pool', type: 'checkbox', icon: 'fas fa-swimming-pool' },
          { name: 'gym', type: 'checkbox', icon: 'fas fa-dumbbell' },
          { name: 'spa', type: 'checkbox', icon: 'fas fa-spa' },
          { name: 'tennis_court', type: 'checkbox', icon: 'fas fa-tennis-ball' },
          { name: 'golf_course', type: 'checkbox', icon: 'fas fa-golf-ball' },
          { name: 'arcade_games', type: 'number', icon: 'fas fa-gamepad' },
          { name: 'bowling_lanes', type: 'number', icon: 'fas fa-bowling-ball' },
        ]},
        { name: 'Outdoor Features', features: [
          { name: 'patio', type: 'checkbox', icon: 'fas fa-umbrella-beach' },
          { name: 'terrace', type: 'checkbox', icon: 'fas fa-sun' },
          { name: 'garden', type: 'checkbox', icon: 'fas fa-leaf' },
          { name: 'pool', type: 'checkbox', icon: 'fas fa-swimming-pool' },
          { name: 'bbq_area', type: 'checkbox', icon: 'fas fa-fire' },
          { name: 'fire_pit', type: 'checkbox', icon: 'fas fa-fire-alt' },
          { name: 'rooftop_access', type: 'checkbox', icon: 'fas fa-building' },
        ]},
        { name: 'Parking and Transportation', features: [
          { name: 'valet_parking', type: 'checkbox', icon: 'fas fa-car' },
          { name: 'self_parking', type: 'checkbox', icon: 'fas fa-parking' },
          { name: 'parking_garage', type: 'checkbox', icon: 'fas fa-warehouse' },
          { name: 'shuttle_service', type: 'checkbox', icon: 'fas fa-bus' },
          { name: 'taxi_stand', type: 'checkbox', icon: 'fas fa-taxi' },
          { name: 'bike_sharing', type: 'checkbox', icon: 'fas fa-bicycle' },
          { name: 'ev_charging', type: 'number', icon: 'fas fa-charging-station' },
        ]},
        { name: 'Accommodation', features: [
          { name: 'on_site_hotel', type: 'checkbox', icon: 'fas fa-hotel' },
          { name: 'nearby_hotels', type: 'number', icon: 'fas fa-bed' },
          { name: 'vip_suites', type: 'number', icon: 'fas fa-crown' },
        ]},
        { name: 'Business Services', features: [
          { name: 'printing', type: 'checkbox', icon: 'fas fa-print' },
          { name: 'copying', type: 'checkbox', icon: 'fas fa-copy' },
          { name: 'fax', type: 'checkbox', icon: 'fas fa-fax' },
          { name: 'business_center', type: 'checkbox', icon: 'fas fa-briefcase' },
          { name: 'high_speed_internet', type: 'checkbox', icon: 'fas fa-wifi' },
          { name: 'conference_call_system', type: 'checkbox', icon: 'fas fa-phone-alt' },
        ]},
        { name: 'Event Planning Services', features: [
          { name: 'event_coordinator', type: 'checkbox', icon: 'fas fa-user-tie' },
          { name: 'staff', type: 'number', icon: 'fas fa-users' },
          { name: 'security', type: 'checkbox', icon: 'fas fa-shield-alt' },
          { name: 'cleaning_crew', type: 'number', icon: 'fas fa-broom' },
        ]},
        { name: 'Cultural and Spiritual', features: [
          { name: 'meditation_room', type: 'checkbox', icon: 'fas fa-om' },
          { name: 'prayer_room', type: 'checkbox', icon: 'fas fa-pray' },
          { name: 'cultural_artifacts', type: 'checkbox', icon: 'fas fa-landmark' },
        ]},
        { name: 'Family and Pet Services', features: [
          { name: 'pet_friendly', type: 'checkbox', icon: 'fas fa-paw' },
          { name: 'child_care', type: 'checkbox', icon: 'fas fa-baby' },
          { name: 'nursing_room', type: 'checkbox', icon: 'fas fa-female' },
        ]},
        { name: 'Luxury Amenities', features: [
          { name: 'luxury_concierge', type: 'checkbox', icon: 'fas fa-bellhop' },
          { name: 'personal_shoppers', type: 'checkbox', icon: 'fas fa-shopping-bag' },
          { name: 'spa_services', type: 'checkbox', icon: 'fas fa-spa' },
        ]},
        { name: 'Advanced Technology', features: [
          { name: 'interactive_screens', type: 'checkbox', icon: 'fas fa-hand-pointer' },
          { name: 'augmented_reality', type: 'checkbox', icon: 'fas fa-glasses' },
          { name: 'holograms', type: 'checkbox', icon: 'fas fa-cube' },
        ]},
        { name: 'Dietary Options', features: [
          { name: 'organic_menu', type: 'checkbox', icon: 'fas fa-leaf' },
          { name: 'vegan_options', type: 'checkbox', icon: 'fas fa-carrot' },
          { name: 'allergen_free', type: 'checkbox', icon: 'fas fa-shield-alt' },
        ]},
        { name: 'Sustainability Features', features: [
          { name: 'recycling_bins', type: 'number', icon: 'fas fa-recycle' },
          { name: 'composting', type: 'checkbox', icon: 'fas fa-leaf' },
          { name: 'rainwater_harvesting', type: 'checkbox', icon: 'fas fa-tint' },
        ]},
      ],
    };
  },
  computed: {
    requiredFacilities() {
      return this.venue.type ? this.venueRequirements[this.venue.type].required : [];
    },
    optionalFacilities() {
      return this.venue.type ? this.venueRequirements[this.venue.type].optional : [];
    },
    allFacilitiesOptions() {
      return this.venue.type ? [...this.venueRequirements[this.venue.type].required, ...this.venueRequirements[this.venue.type].optional] : [];
    },
    currencySymbol() {
      // Simple currency symbol mapping, can be extended
      const symbols = { USD: '$', EUR: '€', GBP: '£' };
      return symbols[this.venue.currency] || this.venue.currency;
    },
  },
  methods: {
    formatTypeName(type) {
      return type.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    },
    formatFeatureName(name) {
      return name.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    },
    updateFacilities() {
      this.venue.facilities = [];
    },
    addTier() {
      this.venue.pricing_tiers.push({ condition: '', rate: null });
    },
    removeTier(index) {
      this.venue.pricing_tiers.splice(index, 1);
    },
    addPackage() {
      this.venue.pricing_packages.push({ name: '', facilities: [], price: null });
    },
    removePackage(index) {
      this.venue.pricing_packages.splice(index, 1);
    },
    addSubscriptionPlan() {
      this.venue.subscription_plans.push({ name: '', price: null, billing_period: 'monthly', benefits: '' });
    },
    removeSubscriptionPlan(index) {
      this.venue.subscription_plans.splice(index, 1);
    },
    addFee() {
      this.venue.additional_fees.push({ name: '', amount: null });
    },
    removeFee(index) {
      this.venue.additional_fees.splice(index, 1);
    },
    submitVenue() {
      const formData = new FormData();
      for (const [key, value] of Object.entries(this.venue)) {
        if (key === 'facilities') {
          this.requiredFacilities.forEach(f => formData.append('facilities[]', f));
          value.forEach(f => formData.append('facilities[]', f));
        } else if (key === 'pricing_tiers' || key === 'pricing_packages' || key === 'subscription_plans' || key === 'additional_fees') {
          formData.append(key, JSON.stringify(value));
        } else {
          formData.append(key, value);
        }
      }
      console.log('Submitting venue:', Object.fromEntries(formData));
      // API call here
    },
  },
};
</script>

<style>
/* Assuming Font Awesome and Tailwind CSS are included in the project */
</style>
