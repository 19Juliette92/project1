import React from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Header from "./components/Header";
import Menu_nav from './components/Menu_nav';
import Home from './paginas/Home'; 
import ListPersonas from './paginas/personas/ListPersonas'; // Asegúrate de tener estos componentes creados
import AddPersona from './paginas/personas/AddPersona'
// import Inmuebles from './components/Inmuebles'; // y exportados adecuadamente.
// import Vehiculos from './components/Vehiculos';
// import Estacionamiento from './components/Estacionamiento';
// import Usuarios from './components/Usuarios';

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
          {/* <Route path="/inmuebles" element={Inmuebles} />
          <Route path="/vehiculos" element={Vehiculos} />
          <Route path="/estacionamiento" element={Estacionamiento} />
          <Route path="/usuarios" element={Usuarios} />
          Otras rutas que necesites */}
        </Routes>
      </div>
    </Router>
  );
}

export default App;