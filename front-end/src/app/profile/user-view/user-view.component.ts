import { Component } from '@angular/core';
import { FooterComponent } from "../../layouts/footer/footer.component";
import { RouterOutlet } from '@angular/router';

@Component({
    selector: 'app-user-view',
    standalone: true,
    templateUrl: './user-view.component.html',
    styleUrl: './user-view.component.css',
    imports: [FooterComponent, RouterOutlet]
})
export class UserViewComponent {

}
