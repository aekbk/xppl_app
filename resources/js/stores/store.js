
import { defineStore } from 'pinia';
import { useLocalStorage } from '@vueuse/core';
import axios from 'axios';

export const useStore = defineStore('store', () => {

  const loginStatus = useLocalStorage('login-status', false);
  const loginUser = useLocalStorage('login-user', '');
  const loginData = useLocalStorage('login-data', {});
  const lang = useLocalStorage('lang', 'en');


  // theme customizer
  const dataLayout = useLocalStorage('data-layout', 'vertical');
  const dataTopbar = useLocalStorage('data-topbar', 'light');
  const dataSidebar = useLocalStorage('data-sidebar', 'dark');
  const dataSidebarSize = useLocalStorage('data-sidebar-size', 'sm');
  const dataSidebarImage = useLocalStorage('data-sidebar-image', 'none');
  const dataPreloader = useLocalStorage('data-preloader', 'disable');
  const dataTheme = useLocalStorage('data-theme', 'default');
  const dataThemeColors = useLocalStorage('data-theme-colors', 'default');
  const dataBsTheme = useLocalStorage('data-bs-theme', 'light');
  const dataLayoutWidth = useLocalStorage('data-layout-width', 'fluid');
  const dataLayoutPosition = useLocalStorage('data-layout-position', 'fixed');
  const dataLayoutStyle = useLocalStorage('data-layout-style', 'default');
  const dataBodyImage = useLocalStorage('data-body-image', 'none');
  const dataSidebarVisibility = useLocalStorage('data-sidebar-visibility', 'show');
  const dataSidebarUser = useLocalStorage('data-sidebar-user', 'false');


  function setCustomizer(attribute, val) {
    document.documentElement.setAttribute(attribute, val);
    switch (attribute) {
      case 'data-layout':
        dataLayout.value = val;
        break;
      case 'data-topbar':
        dataTopbar.value = val;
        break;
      case 'data-sidebar':
        dataSidebar.value = val;
        break;
      case 'data-sidebar-size':
        dataSidebarSize.value = val;
        break;
      case 'data-sidebar-image':
        dataSidebarImage.value = val;
        break;
      case 'data-preloader':
        dataPreloader.value = val;
        break;
      case 'data-theme':
        dataTheme.value = val;
        break;
      case 'data-theme-colors':
        dataThemeColors.value = val;
        break;
      case 'data-bs-theme':
        dataBsTheme.value = val;
        break;
      case 'data-layout-width':
        dataLayoutWidth.value = val;
        break;
      case 'data-layout-position':
        dataLayoutPosition.value = val;
        break;
      case 'data-layout-style':
        dataLayoutStyle.value = val;
        break;
      case 'data-body-image':
        dataBodyImage.value = val;
        break;
      case 'data-sidebar-visibility':
        dataSidebarVisibility.value = val;
        break;
    }
  }

  function showPassword(elementId) {
    document.querySelector(elementId).getAttribute('type') == 'password' ? document.querySelector(elementId).setAttribute('type', 'text') : document.querySelector(elementId).setAttribute('type', 'password');
  }

  function dateTime(value) {
    if (value) {
      return moment(value).format('DD-MM-YYYY HH:mm');
    }
  }

  function dateTime2(value) {
    if (value) {
      return moment(value).format('DD MMMM, YYYY HH:mm');
    }
  }

  function fullMonth(value) {
    if (value) {
      return moment(value).format('DD MMMM YYYY');
    }
  }

  function ddmmyyyy(value) {
    if (value) {
      return moment(value).format('DD-MM-YYYY');
    }
  }

  function yyyymmdd(value) {
    if (value) {
      return moment(value).format('YYYY-MM-DD');
    }
  }

  function yyyy(value) {
    if (value) {
      return moment(value).format('YYYY');
    }
  }

  function mmyyyy(value) {
    if (value) {
      return moment(value).format('MM-YYYY');
    }
  }

  function fullMonY(value) {
    if (value) {
      return moment(value).format('MMMM YYYY');
    }
  }

  function fullMDY(value) {
    if (value) {
      return moment(value).format('MMMM DD, YYYY');
    }
  }

  function numInt(value) {
    if (value == null || value == 0) {
      return '-';
    } else {
      let val = (value / 1).toFixed(0).replace(',', '.');
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
  }

  function numDec(value) {
    if (value == null || value == 0) {
      return '-';
    } else {
      let val = (value / 1).toFixed(2).replace(',', '.');
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
  }

  function bit(value) {
    if (value == 1) {
      return true;
    } else {
      return false;
    }
  }

  function fileType(text) {
    if (text) {
      return text.split('.').pop().toLowerCase();
    }
  }

  function severity(text) {
    if (text == '1') {
      return '1 (Insignificant)';
    } else if (text == '2') {
      return '2 (Low)';
    } else if (text == '3') {
      return '3 (Moderate)';
    } else if (text == '4') {
      return '4 (High)';
    } else {
      return '5 (Extreme)';
    };
  }

  async function getLoginData() {
    const response = await axios('api/login-data');
    loginData.value = response.data;
  }

  return {
    loginStatus,
    loginUser,
    lang,
    loginData,
    dataLayout,
    dataTopbar,
    dataSidebar,
    dataSidebarSize,
    dataSidebarImage,
    dataPreloader,
    dataTheme,
    dataThemeColors,
    dataBsTheme,
    dataLayoutWidth,
    dataLayoutPosition,
    dataLayoutStyle,
    dataBodyImage,
    dataSidebarVisibility,
    dataSidebarUser,
    showPassword,
    setCustomizer,
    getLoginData,
    dateTime,
    dateTime2,
    ddmmyyyy,
    yyyymmdd,
    mmyyyy,
    yyyy,
    fullMonY,
    fullMDY,
    fullMonth,
    numInt,
    numDec,
    bit,
    fileType,
    severity
  }
})