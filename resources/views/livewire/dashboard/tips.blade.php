<div class="bg-[#1f2235] rounded-2xl p-6 shadow-inner mt-6 border border-[#2e3148]">
    <h2 class="text-lg font-semibold mb-2 text-[#9b87f5]">💡 نکته امروز</h2>
    <p class="text-gray-300 leading-relaxed text-xl">
        {{ $tip }}
    </p>
    <button  wire:click="loadRandomTip"  class="btn btn-warning waves-effect waves-light mt-3" >نکته بعدی</button>
</div>
