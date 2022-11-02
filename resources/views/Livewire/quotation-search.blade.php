<div>
    <div class="card-header">
        <input wire:model="search" class="form-control lg:w-full rounded-lg h-8 bg-slate-300 text-lg" placeholder="Ingrese el nro o fecha de la cotizacion">
    </div>
    <div class="card content-center col-span-3 lg:col-span-5">
        <div class="card-body col-span-3 lg:col-span-6">
            <table class=" text-neutral-800 w-full border-collapse border-spacing-1 border-t-green-200">
                <thead class="text-left">
                    <tr>
                        <th>Nro</th>
                        <th>Fecha generada </th>
                        <th>Vecimiento</th>
                        <th>Importe</th>
                        <th>Cliente</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>

                 @foreach ($quotations as $quotation)
                    <tr>
                        <td>{{$quotation->id}}</td>
                        <td>{{$quotation->dateTimeGenerated}}</td>
                        <td>{{$quotation->dateTimeExpiration}}</td>
                        <td class="text-green-500">{{$quotation->finalAmount}}</td>
                        <td>{{$quotation->customer_id}}</td>
                        @if ($quotation->valid === 1)
                        <td class="text-green-500">Valida</td>    
                        @else
                        <td class="text-red-500">Vencida</td>    
                        @endif
                        
                        <td> <button class="text-xs content-center lg:text-sm h-5 px-6 font-semibold hidden:bg-blue-400 rounded-full bg-blue-700 text-white hover:bg-opacity-40" onclick="parent.location = '{{route('quotations.seeQuotation', $quotation->id)}}'">
                            <svg xmlns="http://www.w3.org/2000/svg"  fill="currentColor" class="bi bi-eye h-5 w-5" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                </svg> 
                            </button></td>
                            
                    </tr> 
                 @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
