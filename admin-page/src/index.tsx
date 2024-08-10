import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App';

import 'bootstrap/dist/css/bootstrap.min.css';
import './styles/style.scss';

const root = ReactDOM.createRoot(
  document.getElementById('spaceship_plugin_root_element') as HTMLElement
);
root.render(
  <React.StrictMode>
    <App />
  </React.StrictMode>
);