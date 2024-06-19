import React from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Header from "./components/Header";
import Menu_nav from './components/Menu_nav';
import Home from './paginas/Home'; 
import ListPersonas from './paginas/personas/ListPersonas'; // Asegúrate de tener estos componentes creados
import AddPersona from './paginas/personas/AddPersona';
import EditPersona from './paginas/personas/EditPersona';
import ListInmuebles from './paginas/inmuebles/ListInmuebles';
import AddInmueble from './paginas/inmuebles/AddInmueble';
import EditInmueble from './paginas/inmuebles/EditInmueble';
import ListVehiculos from './paginas/vehiculos/ListVehiculos';
import AddVehiculo from './paginas/vehiculos/AddVehiculo';
import EditVehiculo from './paginas/vehiculos/EditVehiculo';

function App() {
  return (
    <Router>
      <div className="App">
        <Header />
        <Menu_nav />
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/Personas" element={<ListPersonas />} />
          <Route path="/Personas/AddPersona" element={<AddPersona />} />
          <Route path="/personas/edit/:id_persona" element={<EditPersona />} />
          <Route path="/Inmuebles" element={<ListInmuebles />} />
          <Route path="/Inmuebles/AddInmueble" element={<AddInmueble />} />
          <Route path="/inmuebles/edit/:id_inmueble" element={<EditInmueble />} />
          <Route path="/Vehiculos" element={<ListVehiculos />} />
          <Route path="/Vehiculos/AddVehiculo" element={<AddVehiculo />} />
          <Route path="/vehiculos/edit/:placa" element={<EditVehiculo />} />
        </Routes>
      </div>
    </Router>
  );
}

export default App;