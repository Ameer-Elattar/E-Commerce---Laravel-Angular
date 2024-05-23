import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { CarouselModule } from 'primeng/carousel';

@Component({
  selector: 'app-carousel',
  standalone: true,
  imports: [ CarouselModule,CommonModule],
  templateUrl: './carousel.component.html',
  styleUrl: './carousel.component.css'
})
export class CarouselComponent {
  images: any[] = [
    { src: '../../../assets/images/armchair.png', alt: 'Armchair' },
    { src: '../../../assets/images/bed.png', alt: 'Armchair' },
    { src: '../../../assets/images/couch.png', alt: 'Armchair' },
    { src: '../../../assets/images/floor-lamp.png', alt: 'Armchair' },
    { src: '../../../assets/images/furniture.png', alt: 'Armchair' },
    { src: '../../../assets/images/furniture (1).png', alt: 'Armchair' }
  
  ];
}
