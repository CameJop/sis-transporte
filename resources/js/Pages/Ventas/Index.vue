<template>
  <div class="p-6 bg-slate-900 min-h-screen text-slate-100 font-sans">
    <div class="max-w-7xl mx-auto">
      
      <header class="flex flex-col md:flex-row justify-between items-start md:items-center bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-xl mb-6 gap-4">
        <div>
          <h1 class="text-3xl font-extrabold bg-gradient-to-r from-blue-400 to-emerald-400 bg-clip-text text-transparent">
            Terminal Express Hub
          </h1>
          <p class="text-slate-400 text-sm mt-1">Punto de Venta Automatizado e Inteligente</p>
        </div>
        <div class="flex items-center gap-3 bg-slate-900/60 px-4 py-2 rounded-xl border border-slate-700/50">
          <div class="h-3 w-3 rounded-full bg-emerald-500 animate-pulse"></div>
          <span class="text-xs text-slate-300 font-mono">
            Operador: <span class="text-blue-400 font-bold">{{ user_role === 'admin' ? 'Administrador General' : current_user_employee?.nombre }}</span>
          </span>
        </div>
      </header>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <div class="lg:col-span-8 space-y-6">
          
          <section class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg">
            <h2 class="text-lg font-bold text-slate-200 mb-4 flex items-center gap-2">
              🗺️ <span>Selección de Destino y Salidas</span>
            </h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div 
                v-for="viaje in viajes" 
                :key="viaje.id_viaje"
                @click="seleccionarViaje(viaje)"
                :class="[
                  'p-4 rounded-xl cursor-pointer border transition-all duration-200 relative overflow-hidden',
                  form.id_viaje === viaje.id_viaje 
                    ? 'bg-blue-600/20 border-blue-500 ring-2 ring-blue-500/50 shadow-blue-900/20' 
                    : 'bg-slate-900/50 border-slate-700/80 hover:border-slate-600 hover:bg-slate-900'
                ]"
              >
                <div class="flex justify-between items-start mb-2">
                  <span class="text-xs font-bold font-mono px-2 py-0.5 rounded bg-slate-800 text-slate-400">
                    Bus: {{ viaje.bus?.placa }}
                  </span>
                  <span class="text-sm font-extrabold text-emerald-400">
                    {{ viaje.precio_automatico }} Bs.
                  </span>
                </div>
                
                <div class="flex items-center gap-2 my-3 text-sm">
                  <span class="font-bold text-slate-200">{{ viaje.ruta?.origen?.ciudad }}</span>
                  <div class="flex-1 h-0.5 bg-dashed border-t border-dashed border-slate-600 relative flex items-center justify-center">
                    <span class="absolute text-[10px] text-blue-400 bg-slate-900 px-1 rounded border border-slate-700">➔</span>
                  </div>
                  <span class="font-bold text-blue-400">{{ viaje.ruta?.destino?.ciudad }}</span>
                </div>

                <div class="text-xs text-slate-400 flex justify-between items-center mt-2">
                  <span>📅 {{ viaje.fecha_salida }}</span>
                  <span>⏰ {{ viaje.hora_salida.substring(0,5) }}</span>
                </div>
              </div>
            </div>
          </section>

          <section v-if="viajeSeleccionado" class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg">
            <div class="flex justify-between items-center mb-6">
              <h2 class="text-lg font-bold text-slate-200 flex items-center gap-2">
                💺 <span>Distribución de Asientos del Bus ({{ viajeSeleccionado.bus?.placa }})</span>
              </h2>
              <div class="flex gap-4 text-xs">
                <span class="flex items-center gap-1.5"><span class="h-3 w-3 rounded bg-slate-700 border border-slate-600 block"></span> Libre</span>
                <span class="flex items-center gap-1.5"><span class="h-3 w-3 rounded bg-red-600 block"></span> Ocupado</span>
                <span class="flex items-center gap-1.5"><span class="h-3 w-3 rounded bg-blue-500 block"></span> Tu Selección</span>
              </div>
            </div>

            <div class="border-2 border-slate-700 rounded-3xl p-6 bg-slate-950 max-w-md mx-auto relative shadow-inner">
              <div class="w-full flex justify-end mb-6 opacity-40 border-b border-slate-800 pb-3">
                <span class="text-xs font-mono mr-2">FRENTE</span> 🔄
              </div>

              <div class="grid grid-cols-4 gap-3 text-center">
                <template v-for="n in totalAsientosCalculados" :key="n">
                  <div v-if="n % 4 === 3" class="w-2 h-8"></div>
                  
                  <button
                    type="button"
                    @click="marcarAsiento(n.toString().padStart(2, '0'))"
                    :disabled="estaOcupado(n.toString().padStart(2, '0'))"
                    :class="[
                      'h-10 rounded-xl font-mono text-xs font-bold transition-all relative flex items-center justify-center',
                      estaOcupado(n.toString().padStart(2, '0'))
                        ? 'bg-red-950/60 border border-red-800/60 text-red-400 cursor-not-allowed line-through'
                        : form.asiento === n.toString().padStart(2, '0')
                        ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/50 scale-105 border border-blue-400'
                        : 'bg-slate-800 border border-slate-700 text-slate-300 hover:bg-slate-700 hover:border-slate-500'
                    ]"
                  >
                    {{ n.toString().padStart(2, '0') }}
                  </button>
                </template>
              </div>
            </div>
          </section>
          <div v-else class="bg-slate-800/40 border border-dashed border-slate-700 p-12 rounded-2xl text-center text-slate-500">
            Selecciona una ruta de viaje arriba para encender el mapa interactivo de asientos.
          </div>
        </div>

        <div class="lg:col-span-4 space-y-6">
          <section class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg h-fit sticky top-6">
            <h2 class="text-xl font-bold text-slate-200 mb-4 border-b border-slate-700 pb-2">Checkout de Venta</h2>
            
            <form @submit.prevent="finalizarTransaccion" class="space-y-4">
              
              <div>
                <div class="flex justify-between items-center mb-1">
                  <label class="text-xs font-medium text-slate-400 uppercase tracking-wider">Cliente Pasajero</label>
                  <button 
                    type="button" 
                    @click="abrirModalCliente = true" 
                    class="text-xs text-emerald-400 hover:text-emerald-300 flex items-center gap-1 font-bold"
                  >
                    ➕ Registro Rápido
                  </button>
                </div>
                <select v-model="form.id_cliente" class="w-full bg-slate-900 border-slate-700 rounded-xl text-slate-200 shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2.5" required>
                  <option value="" disabled>-- Elige el Pasajero --</option>
                  <option v-for="cliente in listaClientes" :key="cliente.id_cliente" :value="cliente.id_cliente">
                    {{ cliente.nombre }} ({{ cliente.documento_identidad }})
                  </option>
                </select>
              </div>

              <div v-if="user_role === 'admin'">
                <label class="block text-xs font-medium text-slate-400 uppercase tracking-wider mb-1">Cajero Responsable</label>
                <select v-model="form.id_empleado" class="w-full bg-slate-900 border-slate-700 rounded-xl text-slate-200 py-2.5" required>
                  <option value="" disabled>-- Selecciona un operador --</option>
                  <option v-for="emp in empleados" :key="emp.id_empleado" :value="emp.id_empleado">
                    {{ emp.nombre }}
                  </option>
                </select>
              </div>

              <div>
                <label class="block text-xs font-medium text-slate-400 uppercase tracking-wider mb-1">Canal de Pago</label>
                <select v-model="form.id_metodo_pago" class="w-full bg-slate-900 border-slate-700 rounded-xl text-slate-200 py-2.5" required>
                  <option value="" disabled>-- Elige forma de cobro --</option>
                  <option v-for="mp in metodos_pago" :key="mp.id_metodo_pago" :value="mp.id_metodo_pago">
                    {{ mp.descripcion }}
                  </option>
                </select>
              </div>

              <div class="bg-slate-900/80 p-4 rounded-xl border border-slate-700 space-y-2 mt-4">
                <div class="flex justify-between text-xs text-slate-400">
                  <span>Asiento Asignado:</span>
                  <span class="font-mono text-sm font-bold text-slate-200">{{ form.asiento || 'Ninguno' }}</span>
                </div>
                <div class="flex justify-between text-xs text-slate-400 border-b border-slate-800 pb-2">
                  <span>Precio de Ruta:</span>
                  <span class="font-mono text-sm font-bold text-slate-200">{{ form.precio ? form.precio + ' Bs.' : '-' }}</span>
                </div>
                <div class="flex justify-between items-center pt-1">
                  <span class="text-sm font-bold text-slate-300">Total Neto:</span>
                  <span class="text-2xl font-black text-emerald-400 font-mono">{{ form.precio ? form.precio + ' Bs.' : '0.00' }}</span>
                </div>
              </div>

              <button 
                type="submit" 
                :disabled="form.processing || !form.asiento" 
                class="w-full bg-gradient-to-r from-blue-600 to-emerald-600 hover:from-blue-500 hover:to-emerald-500 text-white font-extrabold py-3 px-4 rounded-xl shadow-lg transition duration-200 disabled:opacity-40 disabled:cursor-not-allowed tracking-wide"
              >
                {{ form.processing ? 'Registrando Transacción...' : 'Emitir Factura y Boleto 🚀' }}
              </button>
            </form>
          </section>
        </div>

      </div>
    </div>

    <div v-if="abrirModalCliente" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 z-50">
      <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 max-w-md w-full shadow-2xl relative animate-in fade-in zoom-in-95 duration-150">
        <h3 class="text-xl font-bold text-slate-100 mb-2">Inscripción Express de Pasajero</h3>
        <p class="text-xs text-slate-400 mb-4">Introduce los datos mínimos. Al guardar se autoseleccionará en el panel.</p>
        
        <form @submit.prevent="guardarClienteExpress" class="space-y-4">
          <div>
            <label class="block text-xs font-medium text-slate-400 mb-1">Nombre Completo</label>
            <input type="text" v-model="formCliente.nombre" class="w-full bg-slate-900 border-slate-700 rounded-xl text-slate-200 focus:ring-blue-500" required placeholder="Ej. Juan Perez" />
          </div>
          <div>
            <label class="block text-xs font-medium text-slate-400 mb-1">Documento de Identidad (CI / Pasaporte)</label>
            <input type="text" v-model="formCliente.documento_identidad" class="w-full bg-slate-900 border-slate-700 rounded-xl text-slate-200 focus:ring-blue-500" required placeholder="Ej. 8765432 LP" />
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-medium text-slate-400 mb-1">Teléfono</label>
              <input type="text" v-model="formCliente.telefono" class="w-full bg-slate-900 border-slate-700 rounded-xl text-slate-200 focus:ring-blue-500" placeholder="Ej. 78945612" />
            </div>
            <div>
              <label class="block text-xs font-medium text-slate-400 mb-1">E-mail</label>
              <input type="email" v-model="formCliente.email" class="w-full bg-slate-900 border-slate-700 rounded-xl text-slate-200 focus:ring-blue-500" placeholder="opcional@correo.com" />
            </div>
          </div>

          <div class="flex justify-end gap-3 pt-2">
            <button type="button" @click="abrirModalCliente = false" class="px-4 py-2 bg-slate-700 text-slate-300 rounded-xl hover:bg-slate-600 text-xs font-bold transition">Cancelar</button>
            <button type="submit" :disabled="guardandoCliente" class="px-5 py-2 bg-emerald-600 text-white rounded-xl hover:bg-emerald-500 text-xs font-bold shadow-lg transition">
              {{ guardandoCliente ? 'Guardando...' : 'Guardar y Seleccionar' }}
            </button>
          </div>
        </form>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  facturas: Array,
  clientes: Array,
  empleados: Array,
  metodos_pago: Array,
  viajes: Array,
  user_role: String,
  current_user_employee: Object
});

// Reactividad local para manejo interactivo de la UI
const viajeSeleccionado = ref(null);
const abrirModalCliente = ref(false);

// 1. FORMULARIO PRINCIPAL (Para la venta del Boleto)
const form = useForm({
  id_cliente: '',
  id_empleado: props.user_role === 'empleado' ? (props.current_user_employee?.id_empleado || '') : '',
  id_metodo_pago: '',
  id_viaje: '',
  asiento: '',
  precio: '',
});

// 2. FORMULARIO EXPRESS (Exclusivo para crear el cliente)
const formCliente = useForm({
  nombre: '',
  documento_identidad: '',
  telefono: '',
  email: ''
});

// Vinculación directa con los props para que se mantenga actualizado reactivamente
const listaClientes = computed(() => props.clientes);

// Calculador dinámico del número total de asientos del bus seleccionado
const totalAsientosCalculados = computed(() => {
  return viajeSeleccionado.value ? viajeSeleccionado.value.bus?.capacidad : 0;
});

// Manejador del mapa conceptual de rutas
const seleccionarViaje = (viaje) => {
  viajeSeleccionado.value = viaje;
  form.id_viaje = viaje.id_viaje;
  form.precio = viaje.precio_automatico; // Asignación automática de precio nativo
  form.asiento = ''; // Limpiar asiento previo por seguridad
};

// Comprobar si el asiento está ocupado leyendo el array del backend
const estaOcupado = (nroAsiento) => {
  if (!viajeSeleccionado.value) return false;
  return viajeSeleccionado.value.asientos_ocupados.includes(nroAsiento);
};

// Marcar asiento con el puntero táctil/mouse
const marcarAsiento = (nroAsiento) => {
  form.asiento = nroAsiento;
};

// Registro asistido de cliente usando form.post nativo de Inertia
const guardarClienteExpress = () => {
  formCliente.post(route('ventas.clienteExpress'), {
    preserveScroll: true, 
    
    onSuccess: () => {
      // Cerramos el modal flotante
      abrirModalCliente.value = false;

      // Buscamos el cliente que se acaba de registrar en los props actualizados de Inertia
      const clienteRecienCreado = props.clientes.find(
        c => c.documento_identidad === formCliente.documento_identidad
      );

      // Si lo encuentra, lo deja seleccionado automáticamente en el checkout principal
      if (clienteRecienCreado) {
        form.id_cliente = clienteRecienCreado.id_cliente;
      }

      // Reseteamos el miniformulario del cliente para usos posteriores
      formCliente.reset();
    },
    onError: (errors) => {
      if (errors.documento_identidad) {
        alert(errors.documento_identidad);
      } else {
        alert('Por favor verifica los datos ingresados del cliente.');
      }
    }
  });
};

const finalizarTransaccion = () => {
  // Verificación preventiva antes de enviar
  if (props.user_role === 'admin' && !form.id_empleado) {
    alert('❌ Por favor, selecciona un Cajero Responsable antes de emitir la factura.');
    return;
  }

  form.post(route('ventas.store'), {
    preserveScroll: true,
    
    onSuccess: () => {
      // 1. Guardamos el asiento vendido en una constante temporal antes de limpiar el form
      const asientoVendido = form.asiento;

      // 2. Bloqueamos visualmente el asiento en el mapa interactivo local
      if (viajeSeleccionado.value && asientoVendido) {
        viajeSeleccionado.value.asientos_ocupados.push(asientoVendido);
      }

      // 3. Ahora sí, limpiamos el formulario de manera segura para la siguiente venta
      form.reset('asiento', 'id_cliente', 'id_metodo_pago');
      alert('🚀 ¡Venta procesada, Factura y Boleto registrados con éxito!');
    },
    
    onError: (errors) => {
      // Te mostrará en pantalla la columna exacta que la base de datos o la validación rechazó
      console.log('Errores del servidor:', errors);
      if (errors.error) {
        alert(errors.error);
      } else {
        alert('Faltan datos obligatorios o el asiento ya fue ocupado. Revisa el formulario.');
      }
    }
  });
};
</script>
<style scoped>
/* Estilo decorativo para simular líneas de trayecto */
.bg-dashed {
  background-image: linear-gradient(to right, rgba(255,255,255,0.3) 50%, rgba(255,255,255,0) 50%);
  background-position: top;
  background-size: 8px 1px;
  background-repeat: repeat-x;
}
</style>