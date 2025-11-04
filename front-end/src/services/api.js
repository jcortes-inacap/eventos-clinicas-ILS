// src/services/api.js
/*

  Servicio para interactuar con la API del backend
  Utiliza fetch para hacer solicitudes HTTP, esta ruta base puede cambiar según tu configuración de entorno
  equivale a la ruta que definiste en el archivo .env de laravel

*/
const API_BASE_URL =
  import.meta.env.PUBLIC_API_URL || "http://eventos-clinicas-ils.test/api";

export class ApiService {
  static async request(endpoint, options = {}) {
    const url = `${API_BASE_URL}${endpoint}`;

    const config = {
      headers: {
        "Content-Type": "application/json",
        ...options.headers,
      },
      ...options,
    };

    if (config.body && typeof config.body === "object") {
      config.body = JSON.stringify(config.body);
    }

    try {
      const response = await fetch(url, config);

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      return await response.json();
    } catch (error) {
      console.error("API Error:", error);
      throw error;
    }
  }

  // Métodos específicos API
  static async getUsuarios() {
    return this.request("/usuarios");
  }

  static async getUsuario(id) {
    return this.request(`/usuarios/${id}`);
  }

  static async updateUsuario(id, data) {
    return this.request(`/asignaciones/${id}`, {
      method: "PUT",
      body: data,
    });
  }
  static async deleteUsuario(id) {
    return this.request(`/usuarios/${id}`, {
      method: "DELETE",
    });
  }

  static async getRoles() {
    return this.request("/catalogos/roles");
  }

  static async getCarreras() {
    return this.request("/catalogos/carreras");
  }

  static async getDirectoresCarrera() {
    return this.request("/catalogos/directores-carrera");
  }

  // Nuevos métodos para gestión de estado
  static async getInactiveUsuarios() {
    return this.request("/usuarios/usuarios-inactivos");
  }

  static async getAllUsuarios() {
    return this.request("/usuarios/usuarios-todos");
  }

  static async restoreUsuario(id) {
    return this.request(`/usuarios/${id}/restore`, {
      method: "PATCH",
    });
  }

  // ============================================
  // MÉTODOS PARA GESTIÓN DE EVENTOS (CRUD)
  // ============================================

  // Listar todos los eventos
  static async getEventos() {
    return this.request("/eventos");
  }

  // Ver un evento específico
  static async getEvento(id) {
    return this.request(`/eventos/${id}`);
  }

  // Crear un nuevo evento
  static async createEvento(data) {
    return this.request("/eventos", {
      method: "POST",
      body: data,
    });
  }

  // Actualizar un evento
  static async updateEvento(id, data) {
    return this.request(`/eventos/${id}`, {
      method: "PUT",
      body: data,
    });
  }

  // Eliminar un evento
  static async deleteEvento(id) {
    return this.request(`/eventos/${id}`, {
      method: "DELETE",
    });
  }

  // Filtrar eventos por visibilidad (publico, privado, interno)
  static async getEventosPorVisibilidad(tipo) {
    return this.request(`/eventos/filtrar/visibilidad/${tipo}`);
  }

  // Filtrar eventos por modalidad (presencial, online, hibrida)
  static async getEventosPorModalidad(tipo) {
    return this.request(`/eventos/filtrar/modalidad/${tipo}`);
  }

  // Obtener eventos de un usuario específico
  static async getEventosDeUsuario(idUsuario) {
    return this.request(`/eventos/usuario/${idUsuario}`);
  }

  // ============================================
  // MÉTODOS PARA GESTIÓN DE LUGARES (CRUD)
  // ============================================

  // Listar todos los lugares
  static async getLugares() {
    return this.request("/lugares");
  }

  // Ver un lugar específico
  static async getLugar(id) {
    return this.request(`/lugares/${id}`);
  }

  // Crear un nuevo lugar
  static async createLugar(data) {
    return this.request("/lugares", {
      method: "POST",
      body: data,
    });
  }

  // Actualizar un lugar
  static async updateLugar(id, data) {
    return this.request(`/lugares/${id}`, {
      method: "PUT",
      body: data,
    });
  }

  // Eliminar un lugar
  static async deleteLugar(id) {
    return this.request(`/lugares/${id}`, {
      method: "DELETE",
    });
  }

  // Obtener lugares con cantidad de eventos
  static async getLugaresConEventos() {
    return this.request("/lugares/con-eventos");
  }

  // Filtrar lugares por tipo
  static async getLugaresPorTipo(tipo) {
    return this.request(`/lugares/filtrar/tipo/${tipo}`);
  }

  // Buscar lugares por nombre
  static async buscarLugaresPorNombre(nombre) {
    return this.request(`/lugares/buscar/${nombre}`);
  }

  // ============================================
  // MÉTODOS PARA GESTIÓN DE FECHAS DE EVENTOS (CRUD)
  // ============================================

  // Listar todas las fechas de eventos
  static async getFechasEvento() {
    return this.request("/fechas-evento");
  }

  // Ver una fecha de evento específica
  static async getFechaEvento(id) {
    return this.request(`/fechas-evento/${id}`);
  }

  // Crear una nueva fecha de evento
  static async createFechaEvento(data) {
    return this.request("/fechas-evento", {
      method: "POST",
      body: data,
    });
  }

  // Actualizar una fecha de evento
  static async updateFechaEvento(id, data) {
    return this.request(`/fechas-evento/${id}`, {
      method: "PUT",
      body: data,
    });
  }

  // Eliminar una fecha de evento
  static async deleteFechaEvento(id) {
    return this.request(`/fechas-evento/${id}`, {
      method: "DELETE",
    });
  }

  // Obtener fechas de un evento específico
  static async getFechasPorEvento(idEvento) {
    return this.request(`/fechas-evento/evento/${idEvento}`);
  }
}
