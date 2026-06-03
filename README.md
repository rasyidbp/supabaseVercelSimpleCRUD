# **Implementing a Simple CRUD System with Supabase and Vercel**
### 1. Supabase Configuration
##### Create a new project on Supabase.
##### Go to the SQL Editor and run the following script to create the table:
```
SQL
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT TIMEZONE('utc'::text, NOW())
);
```
##### Go to Settings > General and copy your Project ID.
##### Go to Settings > API and copy your Publishable Key.

### 2. Vercel Deployment
##### Download the project files, upload them to your own Git repository, and import the repository into Vercel (make sure your Vercel is integrated with your Git).
##### Add the following two Environment Variables in your Vercel project settings:
####### Key: "SUPABASE_URL" | Value: https://[change this to ur supabase project id].supabase.co
####### Key: "SUPABASE_KEY" | Value: [paste ur supabase publishable key here]

![If I back it up, is it fat enough? Baby, when I throw it back, is it fast enough?](https://cdn.fbsbx.com/v/t59.2708-21/643415588_1788338841836521_1029495618716218147_n.gif?_nc_cat=110&ccb=1-7&_nc_sid=9dcd69&_nc_ohc=ThsEQLD-pxoQ7kNvwG0qbCa&_nc_oc=AdpXgUhI5UNRsEkydl9U18wQDUiBfCSzsmlUb1KXz7_sjxZZFULKcB8fSDrCCXqRnJc&_nc_zt=7&_nc_ht=cdn.fbsbx.com&_nc_gid=w4Auz5DC10_jUrw8Gnys3w&_nc_ss=7ba8c&oh=03_Q7cD5gEkd1zNzAg9VbMavcKJaB1qSdHR6pGbX0vmgnwUFyHJmQ&oe=6A218F31)
