@props(['color'])
@props(['text'])
<div class="alert-container absolute top-0 z-40 w-[33vw] px-5">
    <div class="h-[50px] text-center alert alert-{{$color??'dark'}}" role="alert">
      {{$text}}
    </div>
</div>

<style>
    @keyframes example {
        0% {
            transform:translate(33vw, -100%)
        }
        25% {
            transform:translate(33vw, 50%)
        }
        50% {
            transform:translate(33vw, 50%)
        }
        100% {
            transform:translate(33vw, -100%)
        }
    }
    
    .alert-container{
        transform:translate(33vw, -100px);
        animation-name: example;
        animation-duration: 3s;

    }

</style>

