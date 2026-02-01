import './bootstrap';
import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Alpine from '@alpinejs/csp';
import Swal from 'sweetalert2'

window.Alpine = Alpine;
Livewire.start();

window.Swal = Swal