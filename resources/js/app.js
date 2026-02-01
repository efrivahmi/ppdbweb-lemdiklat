import './bootstrap';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Csp from '@alpinejs/csp';
import Swal from 'sweetalert2'

// Fix for production build where Csp might be wrapped in 'default'
Alpine.plugin(Csp.default || Csp);
Livewire.start();

window.Swal = Swal