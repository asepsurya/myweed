<audio id="bgMusic" loop>
    <source src="{{ asset('storage/'.$invitation->music) }}" type="audio/mpeg">
</audio>

<button onclick="toggleMusic()"
        class="fixed bottom-5 right-5 bg-black text-white p-3 rounded-full">
    🎵
</button>

<script>
function toggleMusic(){
    let music = document.getElementById('bgMusic');
    music.paused ? music.play() : music.pause();
}
</script>
