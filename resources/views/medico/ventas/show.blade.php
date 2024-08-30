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
                    <h2 class="text-2xl font-bold mb-4">Seleccionar Conceptos:</h2>
                    <div id="conceptos-lista" style="max-height: 500px; overflow-y: auto;">
                        @foreach ($conceptos as $concepto)
                            <div class="mb-4 p-4 rounded border flex items-center justify-between concepto-item">
                                <div class="flex flex-col">
                                    <h3 class="font-bold text-base">{{ $concepto->concepto }}</h3>
                                    <p class="text-sm font-semibold mt-1" style="line-height: 1.1;">Precio Unitario: ${{ number_format($concepto->precio_unitario, 2) }}</p>
                                    <p class="text-xs mt-1" style="line-height: 1.1;">Impuesto: {{ number_format($concepto->impuesto, 2) }}%</p>
                                    <p class="text-xs mt-1" style="line-height: 1.1;">Unidad de Medida: {{ $concepto->unidad_medida }}</p>
                                    <p class="text-xs mt-1" style="line-height: 1.1;">Tipo de Concepto: {{ $concepto->tipo_concepto }}</p>
                                </div>
                                <div>
                                    <button class="bg-[#2D7498] text-white px-3 py-1 text-xs rounded btn-agregar" data-id="{{ $concepto->id_concepto }}" data-nombre="{{ $concepto->concepto }}" data-precio="{{ $concepto->precio_unitario }}" data-impuesto="{{ $concepto->impuesto }}" onclick="agregarAlCarrito(this)">Agregar</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Contenedor del Ticket -->
                <div class="w-1/2 pl-4">
                    <div class="bg-white shadow-md p-4 rounded-md" style="width: 380px; background: #f8f8f8; border: 1px solid #ddd; font-family: 'Courier New', Courier, monospace;">
                        <h2 class="text-xl font-bold mb-4 text-center">Cobro de Consulta</h2>
                        
                        <!-- Tabla para los items del carrito -->
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b">
                                    <th class="py-2">ID</th>
                                    <th>Concepto</th>
                                    <th>Precio</th>
                                    <th>Importe</th>
                                </tr>
                            </thead>
                            <tbody id="carrito-items">
                                <!-- Aquí se mostrarán los conceptos agregados al carrito -->
                            </tbody>
                        </table>

                        <div class="border-t mt-4 pt-4">
                            <p><strong>Precio de la Consulta:</strong> $<span id="precio-consulta">{{ number_format($venta->precio_consulta, 2) }}</span></p>
                            <p><strong>Importe:</strong> <span id="iva">{{ number_format($venta->iva, 2) }}</span>%</p>
                            <p><strong>Total a Pagar:</strong> $<span id="total">{{ number_format($venta->total, 2) }}</span></p>
                        </div>
                        <button onclick="mostrarModal()" class="bg-green-500 text-white px-4 py-2 rounded-md mt-4 w-full">Confirmar Cobro</button>
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
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md w-full hover:bg-blue-700">Actualizar Venta</button>
            </form>            
        </div>
    </div>

    <script>
        let carrito = [];
        let precioConsulta = {{ $venta->precio_consulta }};
        let totalImpuestos = {{ $venta->iva }}; // Inicia con el impuesto de la venta existente
        let totalAPagar = {{ $venta->total }}; // Inicia con el total de la venta existente
    
        function agregarAlCarrito(button) {
            const id = parseInt(button.getAttribute('data-id'));
            const nombre = button.getAttribute('data-nombre');
            const precio = parseFloat(button.getAttribute('data-precio'));
            const impuesto = parseFloat(button.getAttribute('data-impuesto'));
    
            let item = carrito.find(concepto => concepto.id === id);
            if (item) {
                item.cantidad += 1;
            } else {
                carrito.push({ id, nombre, precio, impuesto, cantidad: 1 });
                button.textContent = 'Eliminar';
                button.classList.remove('bg-[#2D7498]');
                button.classList.add('bg-red-500');
                button.setAttribute('onclick', `eliminarDelCarrito(${id}, this)`);
            }
    
            totalImpuestos += impuesto; // Sumar el impuesto del nuevo concepto
            precioConsulta += precio; // Sumar el precio del nuevo concepto al precio de la consulta
            actualizarCarrito();
        }
    
        function actualizarCarrito() {
            let carritoItems = document.getElementById('carrito-items');
            carritoItems.innerHTML = '';
    
            let total = precioConsulta; // Empezar con el precio de la consulta sumado con el de los conceptos agregados
            let calculoImpuesto = (total * totalImpuestos) / 100; // Calcular el nuevo total del impuesto
    
            carrito.forEach(concepto => {
                let subtotal = concepto.precio * concepto.cantidad;
                carritoItems.innerHTML += `
                    <tr class="border-b">
                        <td class="py-2">${concepto.id}</td>
                        <td>${concepto.nombre}</td>
                        <td>$${concepto.precio.toFixed(2)}</td>
                        <td>${concepto.impuesto.toFixed(2)}%</td> <!-- Muestra el impuesto en porcentaje -->
                    </tr>
                `;
            });
    
            total += calculoImpuesto; // Sumar el total con el nuevo cálculo de impuesto
            totalAPagar = total;
    
            document.getElementById('iva').innerText = totalImpuestos.toFixed(2);
            document.getElementById('total').innerText = total.toFixed(2);
            document.getElementById('modal-total').innerText = totalAPagar.toFixed(2); // Actualiza el total en el modal
    
            // Actualizar los campos hidden para enviar al servidor
            document.getElementById('iva-hidden').value = totalImpuestos.toFixed(2);
            document.getElementById('total-hidden').value = total.toFixed(2);
    
            // Convertir el carrito a JSON y almacenarlo en el input hidden
            document.getElementById('conceptos-json').value = JSON.stringify(carrito);
        }
    
        function eliminarDelCarrito(id, button) {
            let item = carrito.find(concepto => concepto.id === id);
            totalImpuestos -= item.impuesto; // Restar el impuesto del concepto eliminado
            precioConsulta -= item.precio; // Restar el precio del concepto eliminado
    
            carrito = carrito.filter(concepto => concepto.id !== id);
            button.textContent = 'Agregar';
            button.classList.remove('bg-red-500');
            button.classList.add('bg-[#2D7498]');
            button.setAttribute('onclick', 'agregarAlCarrito(this)');
            actualizarCarrito();
        }
    
        function mostrarModal() {
            document.getElementById('modal-total').innerText = totalAPagar.toFixed(2);
            document.getElementById('modal-cobro').classList.remove('hidden');
            document.getElementById('modal-cobro').style.display = "flex";
        }
    
        function cerrarModal() {
            document.getElementById('modal-cobro').classList.add('hidden');
            document.getElementById('modal-cobro').style.display = "none";
        }
    
        document.getElementById('pago-con').addEventListener('input', function() {
            const pagoCon = parseFloat(this.value);
            const cambio = pagoCon - totalAPagar;
            document.getElementById('cambio').innerText = (cambio >= 0) ? cambio.toFixed(2) : "Monto insuficiente";
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
