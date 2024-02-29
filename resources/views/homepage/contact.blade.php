@extends('layouts.main')

@section('content-homepage')
<div class="container my-5">
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Visi Kami</button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                <div class="accordion-body">Setiap orang mengalami peningkatan kesehatan tubuh, pikiran, dan jiwa</div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Misi Kami</button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">Memperbaiki tubuh orang, mejadi sehat, sehat, kuat, seimbang dan Meningkatkan kesadaran dan kematangan</div>
            </div>
        </div>
    </div>
</div>
@endsection
