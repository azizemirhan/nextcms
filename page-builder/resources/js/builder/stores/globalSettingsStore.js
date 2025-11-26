import { defineStore } from 'pinia';
import { ref } from 'vue';
import api from '../utils/api';

export const useGlobalSettingsStore = defineStore('globalSettings', () => {
  // State
  const colorPalette = ref([
    { name: 'Primary', value: '#667eea' },
    { name: 'Secondary', value: '#764ba2' },
    { name: 'Success', value: '#10b981' },
    { name: 'Warning', value: '#f59e0b' },
    { name: 'Danger', value: '#ef4444' },
    { name: 'Dark', value: '#1f2937' },
    { name: 'Gray', value: '#6b7280' },
    { name: 'Light', value: '#f9fafb' },
  ]);

  const typographyPresets = ref({
    h1: {
      fontSize: '48px',
      fontWeight: '700',
      lineHeight: '1.2',
      fontFamily: 'Inter',
    },
    h2: {
      fontSize: '40px',
      fontWeight: '700',
      lineHeight: '1.3',
      fontFamily: 'Inter',
    },
    h3: {
      fontSize: '32px',
      fontWeight: '600',
      lineHeight: '1.3',
      fontFamily: 'Inter',
    },
    h4: {
      fontSize: '24px',
      fontWeight: '600',
      lineHeight: '1.4',
      fontFamily: 'Inter',
    },
    h5: {
      fontSize: '20px',
      fontWeight: '500',
      lineHeight: '1.5',
      fontFamily: 'Inter',
    },
    h6: {
      fontSize: '16px',
      fontWeight: '500',
      lineHeight: '1.5',
      fontFamily: 'Inter',
    },
    body: {
      fontSize: '16px',
      fontWeight: '400',
      lineHeight: '1.6',
      fontFamily: 'Inter',
    },
    button: {
      fontSize: '16px',
      fontWeight: '600',
      lineHeight: '1.5',
      fontFamily: 'Inter',
    },
  });

  const googleFonts = ref([]);
  const selectedFonts = ref(['Inter', 'Roboto', 'Open Sans', 'Lato', 'Montserrat']);

  const isLoading = ref(false);

  // Actions
  async function loadGlobalSettings() {
    try {
      isLoading.value = true;
      const response = await api.get('/builder/global-settings');

      if (response.data.colorPalette) {
        colorPalette.value = response.data.colorPalette;
      }
      if (response.data.typographyPresets) {
        typographyPresets.value = response.data.typographyPresets;
      }
      if (response.data.selectedFonts) {
        selectedFonts.value = response.data.selectedFonts;
      }
    } catch (error) {
      console.error('Failed to load global settings:', error);
    } finally {
      isLoading.value = false;
    }
  }

  async function saveGlobalSettings() {
    try {
      await api.put('/builder/global-settings', {
        colorPalette: colorPalette.value,
        typographyPresets: typographyPresets.value,
        selectedFonts: selectedFonts.value,
      });
    } catch (error) {
      console.error('Failed to save global settings:', error);
      throw error;
    }
  }

  function updateColorPalette(index, color) {
    if (index >= 0 && index < colorPalette.value.length) {
      colorPalette.value[index] = color;
    }
  }

  function addColorToPalette(color) {
    colorPalette.value.push(color);
  }

  function removeColorFromPalette(index) {
    if (colorPalette.value.length > 1) {
      colorPalette.value.splice(index, 1);
    }
  }

  function updateTypographyPreset(type, settings) {
    if (typographyPresets.value[type]) {
      typographyPresets.value[type] = { ...typographyPresets.value[type], ...settings };
    }
  }

  async function loadGoogleFonts() {
    try {
      const response = await api.get('/builder/google-fonts');
      if (response.data.fonts) {
        googleFonts.value = response.data.fonts;
      }
    } catch (error) {
      console.error('Failed to load Google Fonts:', error);
      // Fallback to basic list
      googleFonts.value = [
        'Inter', 'Roboto', 'Open Sans', 'Lato', 'Montserrat', 'Poppins', 'Raleway',
        'Nunito', 'Playfair Display', 'Merriweather', 'Oswald', 'Source Sans Pro',
        'Roboto Condensed', 'PT Sans', 'Noto Sans', 'Ubuntu', 'Rubik', 'Work Sans',
        'DM Sans', 'Space Grotesk', 'Plus Jakarta Sans', 'Manrope', 'Outfit',
      ];
    }
  }

  function addSelectedFont(fontFamily) {
    if (!selectedFonts.value.includes(fontFamily)) {
      selectedFonts.value.push(fontFamily);
      loadFontFromGoogle(fontFamily);
    }
  }

  function removeSelectedFont(fontFamily) {
    const index = selectedFonts.value.indexOf(fontFamily);
    if (index > -1) {
      selectedFonts.value.splice(index, 1);
    }
  }

  function loadFontFromGoogle(fontFamily) {
    // Load font dynamically from Google Fonts
    const formattedName = fontFamily.replace(/ /g, '+');
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = `https://fonts.googleapis.com/css2?family=${formattedName}:wght@300;400;500;600;700;800&display=swap`;
    document.head.appendChild(link);
  }

  // Load pre-selected fonts
  function loadSelectedFonts() {
    selectedFonts.value.forEach(font => {
      loadFontFromGoogle(font);
    });
  }

  return {
    // State
    colorPalette,
    typographyPresets,
    googleFonts,
    selectedFonts,
    isLoading,

    // Actions
    loadGlobalSettings,
    saveGlobalSettings,
    updateColorPalette,
    addColorToPalette,
    removeColorFromPalette,
    updateTypographyPreset,
    loadGoogleFonts,
    addSelectedFont,
    removeSelectedFont,
    loadSelectedFonts,
  };
});
