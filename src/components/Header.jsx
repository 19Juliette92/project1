import React, { useState, useEffect } from "react";
import "../styles/Header.css";
import logo from "../assets/img/Intelligate_logo.jpg";

function Header() {
  const [user, setUser] = useState(null);
  const [error, setError] = useState(null);

  useEffect(() => {
    fetch(
      "http://localhost/projects/PDO/usuarios/api.php?apicall=readusuario",
      {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
      }
    )
      .then((response) => response.json())
      .then((data) => {
        if (data.error) {
          setError(data.message);
        } else {
          setUser(data.contenido); // Assuming the user data is returned as an object
        }
      })
      .catch((error) => {
        setError("Error al obtener los datos del usuario.");
        console.error("Error fetching user data:", error);
      });
  }, []);

  return (
    <header className="cabecera-pagina">
      <img src={logo} alt="Logo de INTELLIGATE" className="logo-cabecera" />
      <div className="contenedor_dashboard_info">
        {error && <div className="mensaje-error">{error}</div>}
        {user && (
          <div className="caja_info_dashboard">
            <div className="contenido_dashboard">
              <div className="encabezado_dashboard">{user.nombre_usuario}</div>
              <div className="cuerpo_dashboard">
                <p>Bienvenido {user.nombre_usuario}</p>
                <a href="login/update.php">Actualizar</a>
                <a href="login/logout.php">Salir</a>
              </div>
            </div>
          </div>
        )}
      </div>
    </header>
  );
}

export default Header;
