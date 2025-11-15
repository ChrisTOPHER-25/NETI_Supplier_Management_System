<div>
    @inject('QuotationMaterial', App\Models\QuotationMaterial::class)
    @inject('QuotationMaterialImage', App\Models\QuotationMaterialImage::class)
    @inject('Quotation', App\Models\Quotation::class)
    @inject('SubmittedQuotation', App\Models\SubmittedQuotation::class)
    @inject('Suppliers', App\Models\User::class)
    <div class="text-center">
        <div wire:loading class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    @if (empty($selectedBom))
        <div wire:loading.attr='hidden' class="shadow-sm border-dark-subtle p-4 bg-white rounded-3 text-center">
            <span class="fs-5 fw-light">Please select a BOM</span>
        </div>
    @else
        {{-- Quotation Cards --}}
        <div class="row d-flex gy-3 mb-4 gap-2">
            {{-- Show message if submitted quotations is empty --}}
            @if (empty($submittedQuotations))
                <div class="col">
                    <div wire:loading.attr='hidden'
                        class="shadow-sm border-dark-subtle p-4 bg-white rounded-3 text-center">
                        <span class="fs-5 fw-light">There are no submitted quotations for this BOM yet</span>
                    </div>
                </div>
            @else
                {{-- Show cards if submitted quotations is not empty --}}
                @foreach ($submittedQuotations as $quotation)
                    <div wire:key='quotationCol_{{ $quotation->id }}' class="col-auto pe-0" wire:loading.attr='hidden'>
                        <div wire:key='quotationCard_{{ $quotation->id }}' id="quotationCard_{{ $quotation->id }}"
                            class="card">
                            {{-- Badges --}}
                            <div class="bg-transparent position-absolute text-end pt-2 pe-2 w-100">
                                <span
                                    class="badge rounded-pill
                                    @if ($SubmittedQuotation::where('quotation_id', $quotation->id)->firstOrFail()->status == 'pending') text-bg-warning @endif"
                                    @if ($SubmittedQuotation::where('quotation_id', $quotation->id)->firstOrFail()->status == 'accepted') style="background: #17c700;"
                                    @elseif ($SubmittedQuotation::where('quotation_id', $quotation->id)->firstOrFail()->status == 'declined')
                                        style="background: rgb(255, 52, 52);" 
                                    @endif>
                                    {{ ucfirst($SubmittedQuotation::where('quotation_id', $quotation->id)->firstOrFail()->status) }}
                                </span>
                                <span class="badge rounded-pill text-white" style="background: rgb(18, 119, 0);">Total:
                                    ₱&nbsp;{{ number_format($quotation->total_price, 2) }}</span>
                            </div>
                            {{-- Info --}}
                            <div class="card-body">
                                {{-- Image --}}
                                <div class="row mb-3">
                                    <img wire:loading.attr='hidden'
                                        class="img rounded-top-2 rounded-bottom-0 border-secondary-subtle object-fit-contain"
                                        style="height: 12rem;"
                                        src="{{ route('admin.material_image.show', [
                                            'materialImageFileName' => $QuotationMaterialImage
                                                ::where('material_id', $QuotationMaterial::where('quotation_id', $quotation->id)->first()->id)->first()->file_name,
                                        ]) }}"
                                        alt="...">
                                    {{-- Loading Spinner --}}
                                    <div class="position-absolute">
                                        <div class="col-auto">
                                            <div wire:loading class="spinner-grow spinner-grow-sm text-primary"
                                                role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <hr>
                                </div>
                                {{-- Supplier Name --}}
                                <div class="row">
                                    <h6 class="card-title">{{ $Suppliers::findOrFail($quotation->user_id)->name }}</h6>
                                </div>
                                {{-- Date Submitted --}}
                                <div class="row mb-3">
                                    <small class="fw-light">Date
                                        Submitted:&nbsp;{{ date_format($quotation->created_at, 'm/d/Y') }}</small>
                                </div>
                                <div class="row">
                                    {{-- View Quotation Button --}}
                                    <small
                                        class="viewBtn stretched-link d-flex align-items-center gap-1 justify-content-end"
                                        wire:key='viewQuotation_{{ $quotation->id }}'
                                        id="viewQuotation_{{ $quotation->id }}" data-bs-toggle="modal"
                                        data-bs-target="#quotationModal_{{ $quotation->id }}">
                                        View Quotation
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                                        </svg>
                                    </small>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- View Quotation Info --}}
                    <div wire:ignore wire:key='quotationModal_{{ $quotation->id }}' class="modal fade"
                        id="quotationModal_{{ $quotation->id }}" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <livewire:admin.components.submitted-quotations.view-quotation-info
                                    :quotationId='$quotation->id' wire:key='quotationInfo_{{ $quotation->id }}'>
                            </div>
                        </div>
                    </div>
                
                    @endforeach
                

            @endif
        </div>
    @endif
    <style>
        .card {
            width: 16rem;
            background-color: rgb(223, 223, 223);
            border-radius: 1em;
            overflow: hidden;  
            position: relative;
            z-index: 1;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
            transform: scale(1.10);
        }

        .card::before {
            position: absolute;
            content: '';
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, red, yellow, green, cyan, blue, magenta, red);
            border-radius: 50%;
            top: -50%;
            left: -50%;
            z-index: -1;
            transition: background 0.2s ease;
        }

        .card:hover::before {
            animation: rotate 2s linear infinite;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .card::after {
            position: absolute;
            content: ''; 
            inset: 3px;
            border-radius: 10px;
            background: rgb(255, 255, 255);
            z-index: -1;
        }

        .viewBtn {
            cursor: pointer;
            font-size: 1em;
            background: none;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .viewBtn:hover {
            color: #007bff;
            transform: translateX(5px);
        }
    </style>
</div>
