<!-- Redes Sociales -->
<div class="flex items-center gap-3">
    @if (!empty($contactInfo->social_facebook))
        <a href="{{ $contactInfo->social_facebook }}" target="_blank"
            class="w-10 h-10 bg-blue-600 hover:bg-blue-700 rounded-full flex items-center justify-center transition-colors">
            <i class="fab fa-facebook-f"></i>
        </a>
    @endif
    @if (!empty($contactInfo->social_instagram))
        <a href="{{ $contactInfo->social_instagram }}" target="_blank"
            class="w-10 h-10 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 rounded-full flex items-center justify-center transition-colors">
            <i class="fab fa-instagram"></i>
        </a>
    @endif
    @if (!empty($contactInfo->social_tiktok))
        <a href="{{ $contactInfo->social_tiktok }}" target="_blank"
            class="w-10 h-10 bg-black hover:bg-gray-800 rounded-full flex items-center justify-center transition-colors">
            <i class="fab fa-tiktok"></i>
        </a>
    @endif
    @if (!empty($contactInfo->social_twitter))
        <a href="{{ $contactInfo->social_twitter }}" target="_blank"
            class="w-10 h-10 bg-blue-400 hover:bg-blue-500 rounded-full flex items-center justify-center transition-colors">
            <i class="fab fa-twitter"></i>
        </a>
    @endif
</div>
