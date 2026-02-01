import './bootstrap';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Csp from '@alpinejs/csp';
import Swal from 'sweetalert2'

Alpine.plugin(Csp);
Livewire.start();

window.Swal = Swal