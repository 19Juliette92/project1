import React from 'react';
import { NavLink } from 'react-router-dom'; 
import '../styles/Menu_nav.css';

const Menu_nav = () => {
  return (
    <nav className="navegacion-principal">
      <ul>
        <li><NavLink to="/">Inicio</NavLink></li>
        <li><NavLink to="/personas">Personas</NavLink></li>
        <li><NavLink to="/inmuebles">Inmuebles</NavLink></li>
        <li><NavLink to="/vehiculos">Vehículos</NavLink></li>
        <li><NavLink to="/estacionamientos">Estacionamiento</NavLink></li>
        <li><NavLink to="/usuarios">Usuarios</NavLink></li>
      </ul>
    </nav>
  );
};

export default Menu_nav;
