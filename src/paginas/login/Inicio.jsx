// src/components/Inicio.jsx
import React from 'react';
import { Link } from 'react-router-dom'; // Importa el componente Link de react-router-dom
import '../../styles/registro_inicio.css'; // Asegúrate de que la ruta sea correcta
import logo from "../../assets/img/Intelligate_logo.jpg";

const Inicio = () => {
    return (
        <div className="contenedor_index">
            <div className="caja_index">
                <img src={logo} alt="Logo de IntelliGate" className="logo" />
                <h1 className="titulo_index">Bienvenido a IntelliGate</h1>
                <h2>Ingresa o Regístrate</h2>
                {/* Utiliza Link en lugar de <a> para la navegación interna */}
                <Link to="/login" className="btn-ingresa">Ingresa</Link>
                <br />
                <Link to="/register" className="btn-registro">Regístrate</Link>
            </div>
        </div>
    );
};

export default Inicio;
