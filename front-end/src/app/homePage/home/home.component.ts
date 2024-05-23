import { Component } from '@angular/core';
import { CarouselComponent } from '../carousel/carousel.component';
import { ContentComponent } from '../content/content.component';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [CarouselComponent,ContentComponent],
  templateUrl: './home.component.html',
  styleUrl: './home.component.css'
})
export class HomeComponent {

}
