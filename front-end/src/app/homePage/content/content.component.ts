import { Component } from '@angular/core';
import { FooterComponent } from '../../layouts/footer/footer.component';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-content',
  standalone: true,
  templateUrl: './content.component.html',
  styleUrl: './content.component.css',
  imports: [FooterComponent, CommonModule],
})
export class ContentComponent {
  panels = [1, 2, 3, 4, 5, 6, 7, 8];

  constructor() {}

  getPanelBackground(panel: number): string {
    const images = [
      './assets/images/hp-1-ig-4.jpg',
      './assets/images/hp-1-ig-5.jpg',
      './assets/images/hp-1-ig-1.jpg',
      './assets/images/4.jpg',
      './assets/images/project-3.jpg',
      './assets/images/hp-1-ig-2.jpg',
      './assets/images/news-10.jpg',
      './assets/images/project-1.jpg',
    ];
    return `url(${images[panel - 1]})`;
  }
}
