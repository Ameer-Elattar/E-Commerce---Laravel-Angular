import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { CarouselComponent } from './homePage/carousel/carousel.component';
import { NavbarComponent } from './homePage/navbar/navbar.component';
import { FooterComponent } from './homePage/footer/footer.component';
import { ContentComponent } from './homePage/content/content.component';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet ,CarouselComponent , NavbarComponent ,FooterComponent,ContentComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  title = 'front-end';
}
