// // import React, { useState, useEffect } from "react";
// // import "../styles/Header.css";
// // import logo from "../assets/img/Intelligate_logo.jpg";

// // function Header() {
// //   const [user, setUser] = useState(null);
// //   const [error, setError] = useState(null);

// //   useEffect(() => {
// //     fetch("http://localhost/project1/src/api/PDO/usuarios/api.php?apicall=readusuario", {
// //       method: "GET",
// //       headers: {
// //         "Content-Type": "application/json",
// //       },
// //     })
// //       .then((response) => {
// //         if (!response.ok) {
// //           throw new Error(`HTTP error! status: ${response.status}`);
// //         }
// //         return response.json();
// //       })
// //       .then((data) => {
// //         if (data.error) {
// //           setError(data.message || "Error desconocido al obtener los datos del usuario.");
// //         } else {
// //           setUser(data.contenido);
// //         }
// //       })
// //       .catch((error) => {
// //         setError("Error al obtener los datos del usuario.");
// //         console.error("Error fetching user data:", error);
// //       });
// //   }, []);

// //   return (
// //     <header className="cabecera-pagina">
// //       <img src={logo} alt="Logo de INTELLIGATE" className="logo-cabecera" />
// //       <div className="contenedor_dashboard_info">
// //         {error && <div className="mensaje-error">{error}</div>}
// //         {user && (
// //           <div className="caja_info_dashboard">
// //             <div className="contenido_dashboard">
// //               <div className="encabezado_dashboard">{user.nombre_usuario}</div>
// //               <div className="cuerpo_dashboard">
// //                 <p>Bienvenido {user.nombre_usuario}</p>
// //                 <a href="login/update.php">Actualizar</a>
// //                 <a href="/">Salir</a>
// //               </div>
// //             </div>
// //           </div>
// //         )}
// //       </div>
// //     </header>
// //   );
// // }

// // export default Header;

// import React, { useEffect, useState } from "react";
// import "../styles/Header.css";
// import logo from "../assets/img/Intelligate_logo.jpg";

// function Header() {
//   const [user, setUser] = useState(null);
//   const [error, setError] = useState(null);

//   useEffect(() => {
//     const storedUser = localStorage.getItem("user");
//     console.log("Stored user from localStorage:", storedUser); // Depuración

//     if (storedUser) {
//       setUser(JSON.parse(storedUser));
//     } else {
//       setError("No se encontró información del usuario.");
//     }
//   }, []);

//   return (
//     <header className="cabecera-pagina">
//       <img src={logo} alt="Logo de INTELLIGATE" className="logo-cabecera" />
//       <div className="contenedor_dashboard_info">
//         {error && <div className="mensaje-error">{error}</div>}
//         {user ? (
//           <div className="caja_info_dashboard">
//             <div className="contenido_dashboard">
//               <div className="encabezado_dashboard">
//                 <p>
//                   <span style={{ fontWeight: "bold" }}>Bienvenido</span>
//                   <br />
//                   {user.nombre_usuario}
//                 </p>
//               </div>
//               <div className="cuerpo_dashboard">
//                 <a href="/update">Actualizar</a>
//                 <a href="/" onClick={() => localStorage.removeItem("user")}>
//                   Salir
//                 </a>
//               </div>
//             </div>
//           </div>
//         ) : (
//           <div className="caja_info_dashboard">
//             <p>Cargando información del usuario...</p>
//           </div>
//         )}
//       </div>
//     </header>
//   );
// }

// export default Header;

import React, { useEffect, useState } from "react";
import "../styles/Header.css";
import logo from "../assets/img/Intelligate_logo.jpg";
import { useNavigate } from "react-router-dom";

function Header() {
  const [user, setUser] = useState(null);
  const [error, setError] = useState(null);
  const navigate = useNavigate();

  useEffect(() => {
    const storedUser = localStorage.getItem("user");
    console.log("Stored user from localStorage:", storedUser); // Depuración

    if (storedUser) {
      setUser(JSON.parse(storedUser));
    } else {
      setError("No se encontró información del usuario.");
    }
  }, []);

  const handleUpdateClick = () => {
    if (user) {
      navigate(`/Usuarios/edit/${user.id_usuario}`);
    }
  };

  const handleLogout = () => {
    localStorage.removeItem("user");
    navigate("/"); // Redirige a la página de inicio
  };

  return (
    <header className="cabecera-pagina">
      <img src={logo} alt="Logo de INTELLIGATE" className="logo-cabecera" />
      <div className="contenedor_dashboard_info">
        {error && <div className="mensaje-error">{error}</div>}
        {user ? (
          <div className="caja_info_dashboard">
            <div className="contenido_dashboard">
              <div className="encabezado_dashboard">
                <p>
                  <span style={{ fontWeight: "bold" }}>Bienvenido</span>
                  <br />
                  {user.nombre_usuario}
                </p>
              </div>
              <div className="cuerpo_dashboard">
                <button className="boton-cuerpo" onClick={handleUpdateClick}>Actualizar</button>
                <button
                  className="boton-cuerpo"
                  onClick={() => {
                    localStorage.removeItem("user");
                    navigate("/"); // Redirige a la página de inicio
                  }}
                >
                  Salir
                </button>
              </div>
            </div>
          </div>
        ) : (
          <div className="caja_info_dashboard">
            <p>Cargando información del usuario...</p>
          </div>
        )}
      </div>
    </header>
  );
}

export default Header;
