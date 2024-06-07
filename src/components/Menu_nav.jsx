import React from 'react';
import '../styles/Menu_nav.css';

const Menu_nav = () => {
  return (
    <nav className="navegacion-principal">
      <ul>
        <li><a href="personas/index.php">Personas</a></li>
        <li><a href="inmuebles/index_i.php">Inmuebles</a></li>
        <li><a href="vehiculos/index_v.php">Vehículos</a></li>
        <li><a href="estacionamientos/index_e.php">Estacionamiento</a></li>
        <li><a href="usuarios/index_u.php">Usuarios</a></li>
      </ul>
    </nav>
  );
};

export default Menu_nav;
