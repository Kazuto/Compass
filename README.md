<p align="center"><img src="https://github.com/Kazuto/compass/assets/25435034/6505dad2-9255-4c34-b192-e38efc2ae682" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/kazuto/compass/actions"><img src="https://github.com/kazuto/compass/workflows/CI/badge.svg" alt="Build Status"></a>
</p>

## About Compass
"Compass" is a bookmark aggregation tool meticulously crafted to address the shortcomings of existing platforms such as Heimdall and Flame. Recognizing the need for enhanced collaboration and control, Compass introduces several groundbreaking features, including multi-user authentication, team functionalities, and customizable visibility settings for bookmark groups.

## Key Features:

1. **Multi-User Authentication:**
   Compass takes bookmark management to a new level by introducing robust multi-user authentication. This feature allows teams and individuals to have secure and personalized access to their bookmarked content, ensuring data privacy and integrity.


2. **Team Collaboration:**
   One of Compass's standout features is its team collaboration functionality. Users can create teams, making it easier to collaborate on bookmark collections. This is especially beneficial for projects or departments that require shared access to curated resources.


3. **Visibility Controls:**
   Compass empowers users with granular control over the visibility of bookmark groups. You can designate specific groups to be visible only to certain teams, fostering a tailored and organized approach to information sharing within organizations.


4. **Role-Based Access:**
   To enhance security and streamline workflows, Compass incorporates role-based access controls. Administrators can assign different roles to team members, regulating their level of access and authority within the bookmarking system.


5. **Centralized Administration Panel:**
   A centralized administration panel makes managing user accounts, teams, and visibility settings straightforward. This ensures that administrators have a comprehensive view of the bookmarking ecosystem and can make real-time adjustments as needed.


6. **User-Friendly Interface:**
   Despite its powerful features, Compass maintains a user-friendly interface. Navigating through bookmark groups, teams, and visibility settings is intuitive, making the tool accessible to users with varying levels of technical expertise.

In summary, Compass is a bookmark aggregation tool that not only addresses the deficiencies of its predecessors but also introduces cutting-edge features like multi-user authentication, team collaboration, and visibility controls. It is positioned to transform how teams collaborate, share information, and manage their collective knowledge effectively.

## Installing Compass
### Docker
**Environment variables**

| Name | Default | Description |
|:-|:-|:-|
| ADMIN_USERNAME | admin | administrator username |
| ADMIN_PASSWORD | password | administrator password |
| ADMIN_EMAIL | admin@app.test | administrator email|
| TEXT_COLOR | ![ffffff](https://github.com/Kazuto/compass/assets/25435034/e6935346-04fe-41ee-a9fc-f1bd0a0eaa6c) #ffffff | text color |
| ACCENT_COLOR | ![c6a375](https://github.com/Kazuto/compass/assets/25435034/65a568b1-dbe0-40ad-b497-ef11dc2ee619) #c6a375 | primary (accent) color of links, buttons etc. |
| BACKGROUND_COLOR | ![142534](https://github.com/Kazuto/compass/assets/25435034/ab355db3-a25f-4240-9d79-f7d4480ff926) #142534 | background color |
| GITHUB_CLIENT_ID |  | GitHub OAuth client id |
| GITHUB_CLIENT_SECRET |  | GitHub OAuth client secret |

```
  compass:
    image: devkazuto/compass:latest
    container_name: compass
    ports:
      - 80:80
    environment:
      - ADMIN_USERNAME=
      - ADMIN_PASSWORD=
      - ADMIN_EMAIL=
    restart: unless-stopped
```

### Manual Installation
**Prerequisites**
- PHP 8.1 or newer

**Instructions**
1. Clone this repository
2. Set the admin configuration `(default is admin/password)`
    ```
    ADMIN_USERNAME=
    ADMIN_EMAIL=
    ADMIN_PASSWORD=
    ```
3. Run `composer setup`

*Optionally:*
If you want to enable SSO via GitHub or Teams
1. Create a new [GitHub OAuth app](https://github.com/settings/developers)
2. Configure `.env` with app credentials
    ```
   GITHUB_CLIENT_ID=
   GITHUB_CLIENT_SECRET=
    ```
3. Create `whitelist` records in the settings page

## Contributing

Thank you for considering contributing to compass! The contribution guide can be found in the [CONTRIBUTING.md](/CONTRIBUTING.md).
