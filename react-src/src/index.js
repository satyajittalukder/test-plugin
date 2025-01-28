import React from 'react';
import { render } from 'react-dom';
import App from './App';

// This is the element where the React app will be rendered in the WordPress admin.
const settingsPageContainer = document.getElementById('user-test-setings');

if (settingsPageContainer) {
  render(<App />, settingsPageContainer);
}
