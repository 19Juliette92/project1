import React from "react";
import { BrowserRouter as Router, Route, Routes, useLocation } from "react-router-dom";
import Inicio from "./paginas/login/Inicio";
import Login from "./paginas/login/Login";
import Register from "./paginas/login/Register";
import Header from "./components/Header";
import Menu_nav from "./components/Menu_nav";
import Footer from "./components/Footer";
import Home from "./paginas/Home";
import ListPersonas from "./paginas/personas/ListPersonas";
import AddPersona from "./paginas/personas/AddPersona";
import EditPersona from "./paginas/personas/EditPersona";
import ListInmuebles from "./paginas/inmuebles/ListInmuebles";
import AddInmueble from "./paginas/inmuebles/AddInmueble";
import EditInmueble from "./paginas/inmuebles/EditInmueble";
import ListVehiculos from "./paginas/vehiculos/ListVehiculos";
import AddVehiculo from "./paginas/vehiculos/AddVehiculo";
import EditVehiculo from "./paginas/vehiculos/EditVehiculo";
import ListEstacionamientos from "./paginas/estacionamientos/ListEstacionamientos";
import AddEstacionamiento from "./paginas/estacionamientos/AddEstacionamiento";
import EditEstacionamiento from "./paginas/estacionamientos/EditEstacionamiento";
import ListUsuarios from "./paginas/usuarios/ListUsuarios";
import AddUsuario from "./paginas/usuarios/AddUsuario";
import EditUsuario from "./paginas/usuarios/EditUsuario";

function App() {
  const location = useLocation();
  const isInicio = location.pathname === "/"; // Verifica si la ruta actual es "/"
  const isLogin = location.pathname === "/login";
  const isRegister = location.pathname === "/register";

  return (
    <div className="App">
      {isInicio ? (
        <Routes>
          <Route path="/" element={<Inicio />} />
        </Routes>
        ) : isLogin ? (
          <Routes>
            <Route path="/login" element={<Login />} />
          </Routes>
          ) : isRegister ? (
            <Routes>
              <Route path="/register" element={<Register />} />
            </Routes>
      ) : (
        <>
          <Header />
          <Menu_nav />
          <Routes>
            <Route path="/home" element={<Home />} />
            <Route path="/Personas" element={<ListPersonas />} />
            <Route path="/Personas/AddPersona" element={<AddPersona />} />
            <Route path="/personas/edit/:id_persona" element={<EditPersona />} />
            <Route path="/Inmuebles" element={<ListInmuebles />} />
            <Route path="/Inmuebles/AddInmueble" element={<AddInmueble />} />
            <Route path="/inmuebles/edit/:id_inmueble" element={<EditInmueble />} />
            <Route path="/Vehiculos" element={<ListVehiculos />} />
            <Route path="/Vehiculos/AddVehiculo" element={<AddVehiculo />} />
            <Route path="/vehiculos/edit/:placa" element={<EditVehiculo />} />
            <Route path="/Estacionamientos" element={<ListEstacionamientos />} />
            <Route path="/Estacionamientos/AddEstacionamiento" element={<AddEstacionamiento />} />
            <Route path="/Estacionamientos/edit/:id_estacionamiento" element={<EditEstacionamiento />} />
            <Route path="/Usuarios" element={<ListUsuarios />} />
            <Route path="/Usuarios/AddUsuario" element={<AddUsuario />} />
            <Route path="/Usuarios/edit/:id_usuario" element={<EditUsuario />} />
          </Routes>
          <Footer />
        </>
      )}
    </div>
  );
}

function WrappedApp() {
  return (
    <Router>
      <App />
    </Router>
  );
}

export default WrappedApp;
