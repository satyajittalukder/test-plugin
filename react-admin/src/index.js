import React from 'react';
import { render } from 'react-dom';
import App from './App';

const settingsPageContainer = document.getElementById('user-test-setings');

if (settingsPageContainer) {
  render(<App />, settingsPageContainer);
}