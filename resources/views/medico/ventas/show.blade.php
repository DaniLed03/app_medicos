<x-app-layout>
    <div class="bg-gray-100 min-h-screen flex justify-center items-center">
        <div class="bg-white shadow-lg rounded-lg p-8 mx-4 my-8" style="width: 1700px; height: 800px;">
            <!-- Información del Paciente -->
            <div class="flex justify-between items-center mb-6 border-b-2 pb-4">
                <div class="flex items-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-white text-xl font-bold border-2" style="border-color: #2D7498; color: #33AD9B;">
                        {{ substr($paciente->nombres, 0, 1) }}{{ substr($paciente->apepat, 0, 1) }}
                    </div>
                    <h2 class="text-3xl font-bold text-left ml-4" style="color: black;">
                        {{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}
                    </h2>
                </div>
                <p class="text-lg font-medium">
                    Edad: 
                    <?php
                        $fecha_nacimiento = \Carbon\Carbon::parse($paciente->fechanac);
                        $edad = $fecha_nacimiento->diff(\Carbon\Carbon::now());
                        echo $edad->y . ' años ' . $edad->m . ' meses ' . $edad->d . ' días';
                    ?>
                </p>
            </div>

            <!-- Contenido Principal: Conceptos y Ticket -->
            <div class="flex" style="height: calc(100% - 128px);">
                <!-- Contenedor de Selección de Conceptos -->
                <div class="w-1/2 pr-4">
                    <h2 class="text-2xl font-bold mb-4">Conceptos:</h2>
                    
                    <!-- Buscador de Conceptos -->
                    <input type="text" id="buscar-concepto" class="border rounded p-2 w-full mb-4" placeholder="Buscar concepto...">

                    <div id="conceptos-lista" style="max-height: 500px; overflow-y: auto;">
                        <table class="w-full text-left table-auto">
                            <thead>
                                <tr>
                                    <th class="border px-2 py-2">ID</th>
                                    <th class="border px-2 py-2">Tipo</th>
                                    <th class="border px-2 py-2">Concepto</th>
                                    <th class="border px-2 py-2">Precio</th>
                                    <th class="border px-2 py-2">Cant.</th>
                                    <th class="border px-2 py-2">Acción</th>
                                </tr>
                            </thead>
                            <tbody id="conceptos-tbody">
                                @foreach ($conceptos as $concepto)
                                    <tr class="cursor-pointer hover:bg-gray-200 {{ $concepto->tipo_concepto === 'Consulta' ? 'bg-gray-300' : '' }}">
                                        <td class="border px-2 py-2">{{ $concepto->id_concepto }}</td>
                                        <td class="border px-2 py-2">{{ $concepto->tipo_concepto }}</td>
                                        <td class="border px-2 py-2">{{ $concepto->concepto }}</td>
                                        <td class="border px-2 py-2">${{ number_format($concepto->precio_unitario, 2) }}</td>
                                        @if ($concepto->concepto !== 'Consulta')
                                            <td class="border px-2 py-2">
                                                <input type="number" id="cantidad-{{ $concepto->id_concepto }}" class="border rounded p-1 w-12 text-center" value="1" min="1">
                                            </td>
                                            <td class="border px-2 py-2 text-center">
                                                <button id="accion-{{ $concepto->id_concepto }}" class="bg-green-500 text-white px-2 py-1 rounded-md" onclick="toggleConcepto({{ $concepto->id_concepto }}, '{{ $concepto->concepto }}', {{ $concepto->precio_unitario }}, {{ $concepto->impuesto }})">+</button>
                                            </td>
                                        @else
                                            <td class="border px-2 py-2 text-center" colspan="2">No disponible</td>
                                        @endif                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Contenedor del Ticket -->
                <div class="w-1/2 pl-4">
                    <div class="bg-white shadow-md p-4 rounded-md" style="background: #f8f8f8; border: 1px solid #ddd; font-family: 'Courier New', Courier, monospace; height: 100%;">
                        <h2 class="text-xl font-bold mb-4 text-center">Cobro de Consulta</h2>
                        
                        <!-- Tabla para los items del carrito -->
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b">
                                    <th class="py-2">ID</th>
                                    <th>Concepto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Importe</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Consulta siempre presente -->
                                <tr class="border-b">
                                    <td class="py-2">1</td>
                                    <td>Consulta</td>
                                    <td>${{ number_format($venta->precio_consulta, 2) }}</td>
                                    <td>1</td>
                                    <td>${{ number_format(($venta->precio_consulta * $venta->iva) / 100, 2) }}</td> <!-- Muestra solo el valor del impuesto -->
                                </tr>
                                <!-- Aquí se mostrarán los conceptos agregados al carrito -->
                                <tbody id="carrito-items">
                                </tbody>
                            </tbody>
                        </table>

                        <div style="text-align: right; border-top: 1px solid #ddd; margin-top: 1rem; padding-top: 1rem;">
                            <p><strong>Importe:</strong> <span id="iva">{{ number_format($venta->iva, 2) }}</span>%</p>
                            <p><strong>Total a Pagar:</strong> $<span id="total">{{ number_format($venta->total, 2) }}</span></p>
                        </div>
                        <button onclick="mostrarModal()" id="confirmar-cobro" class="bg-green-500 text-white px-4 py-2 rounded-md mt-4 w-full">Confirmar Cobro</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal-cobro" class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="modal-content bg-white shadow-lg rounded-lg p-8 mx-4 relative" style="width: 450px;">
            <button class="absolute top-4 right-4 text-gray-500 hover:text-black cursor-pointer text-2xl font-bold focus:outline-none" onclick="cerrarModal()">
                &times;
            </button>
            <h2 class="text-3xl font-bold text-center mb-4" style="color: black;">Total a Pagar: $<span id="modal-total">{{ number_format($venta->total, 2) }}</span></h2>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="pago-con">Pago con:</label>
                <input type="number" id="pago-con" class="border rounded p-2 w-full focus:ring focus:ring-opacity-50 focus:ring-[#2D7498]" placeholder="Ingrese monto">
            </div>
            
            <p class="mb-4 text-gray-700 text-sm font-bold">Cambio: $<span id="cambio">0.00</span></p>
            
            <form id="form-cobrar" method="POST" action="{{ route('ventas.actualizar', $venta->id) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="iva" id="iva-hidden" value="{{ $venta->iva }}">
                <input type="hidden" name="total" id="total-hidden" value="{{ $venta->total }}">
                <input type="hidden" name="conceptos" id="conceptos-json">
                
                <!-- Método de Pago -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="tipo-pago">Método de Pago:</label>
                    <select id="tipo-pago" name="tipo_pago" class="border rounded p-2 w-full focus:ring focus:ring-opacity-50 focus:ring-[#2D7498]">
                        <option value="Efectivo">Efectivo</option>
                        <option value="Transferencia">Transferencia</option>
                        <option value="Credito">Crédito</option>
                        <option value="Debito">Débito</option>
                    </select>
                </div>
                
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md w-full hover:bg-blue-700">Actualizar Venta</button>
            </form>
                        
        </div>
    </div>


    <script>
        let carrito = [];
        let precioConsulta = {{ $venta->precio_consulta }};
        let totalImpuestos = {{ $venta->iva }};
        let totalAPagar = {{ $venta->total }};

        // No es necesario agregar la consulta al carrito, ya que se incluye en el total base

        let totalBase = {{ $venta->total }}; // Mantener el total base de la venta existente

        // Actualizar carrito al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            actualizarCarrito();
        });

        function toggleConcepto(id, nombre, precio, impuesto) {
            let cantidadInput = document.getElementById(`cantidad-${id}`);
            let cantidad = parseInt(cantidadInput.value);
            let boton = document.getElementById(`accion-${id}`);
            let item = carrito.find(concepto => concepto.id === id);

            if (item) {
                carrito = carrito.filter(concepto => concepto.id !== id);
                boton.classList.remove('bg-red-500');
                boton.classList.add('bg-green-500');
                boton.innerText = '+';
                totalImpuestos -= item.impuesto * item.cantidad;
                totalAPagar -= (item.precio + item.impuesto) * item.cantidad;
            } else {
                carrito.push({ id, nombre, precio, impuesto, cantidad });
                boton.classList.remove('bg-green-500');
                boton.classList.add('bg-red-500');
                boton.innerText = '-';
                totalImpuestos += impuesto * cantidad;
                totalAPagar += (precio + impuesto) * cantidad;
            }

            actualizarCarrito();
        }

        function actualizarCarrito() {
            let carritoItems = document.getElementById('carrito-items');
            carritoItems.innerHTML = '';

            let total = totalBase; // Mantener el total base sin recalcular la consulta
            let calculoImpuesto = 0; // Reiniciar el cálculo de impuestos adicionales

            carrito.forEach(concepto => {
                let subtotal = concepto.precio * concepto.cantidad;
                let impuestoConcepto = (concepto.precio * concepto.cantidad * concepto.impuesto) / 100; // Calcular el impuesto por concepto
                calculoImpuesto += impuestoConcepto; // Sumar los impuestos de cada concepto
                total += subtotal + impuestoConcepto; // Sumar el subtotal y el impuesto al total

                carritoItems.innerHTML += `
                    <tr class="border-b">
                        <td class="py-2">${concepto.id}</td>
                        <td>${concepto.nombre}</td>
                        <td>$${concepto.precio.toFixed(2)}</td>
                        <td>${concepto.cantidad}</td>
                        <td>$${impuestoConcepto.toFixed(2)}</td> <!-- Mostrar el valor del impuesto aplicado -->
                    </tr>
                `;
            });

            totalAPagar = total; // Actualizar el total a pagar con el total calculado

            document.getElementById('iva').innerText = totalImpuestos.toFixed(2);
            document.getElementById('total').innerText = total.toFixed(2);
            document.getElementById('modal-total').innerText = totalAPagar.toFixed(2); // Actualiza el total en el modal

            // Actualizar los campos hidden para enviar al servidor
            document.getElementById('iva-hidden').value = totalImpuestos.toFixed(2);
            document.getElementById('total-hidden').value = total.toFixed(2);

            // Convertir el carrito a JSON y almacenarlo en el input hidden
            document.getElementById('conceptos-json').value = JSON.stringify(carrito);
        }

        function mostrarModal() {
            document.getElementById('modal-cobro').classList.remove('hidden');
            document.getElementById('modal-cobro').style.display = "flex";
        }

        document.getElementById('form-cobrar').addEventListener('submit', function() {
            // Asegúrate de que el tipo de pago se envíe con el formulario
            const tipoPago = document.getElementById('tipo-pago').value;
            document.querySelector('input[name="tipo_pago"]').value = tipoPago;
        });


        function cerrarModal() {
            document.getElementById('modal-cobro').classList.add('hidden');
            document.getElementById('modal-cobro').style.display = "none";
        }

        document.getElementById('pago-con').addEventListener('input', function() {
            const pagoCon = parseFloat(this.value);
            const cambio = pagoCon - totalAPagar;
            document.getElementById('cambio').innerText = (cambio >= 0) ? cambio.toFixed(2) : "Monto insuficiente";
        });

        // Buscador de conceptos
        document.getElementById('buscar-concepto').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const conceptos = document.querySelectorAll('#conceptos-tbody tr');

            conceptos.forEach(concepto => {
                const texto = concepto.innerText.toLowerCase();
                concepto.style.display = texto.includes(query) ? '' : 'none';
            });
        });

        // Cerrar el modal si se hace clic fuera del contenido
        window.onclick = function(event) {
            const modal = document.getElementById('modal-cobro');
            if (event.target === modal) {
                cerrarModal();
            }
        }


    </script>
</x-app-layout>
