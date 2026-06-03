#Implementing a Simple CRUD System with Supabase and Vercel
##1. Supabase Configuration
###Create a new project on Supabase.
###Go to the SQL Editor and run the following script to create the table:

####SQL
####CREATE TABLE users (
####    id SERIAL PRIMARY KEY,
####    name TEXT NOT NULL,
####    email TEXT UNIQUE NOT NULL,
####    created_at TIMESTAMP WITH TIME ZONE DEFAULT TIMEZONE('utc'::text, NOW())
####);

###Go to Settings > General and copy your Project ID.
###Go to Settings > API and copy your Publishable Key.

##2. Vercel Deployment
###Download the project files, upload them to your own Git repository, and import the repository into Vercel (make sure your Vercel is integrated with your Git).
###Add the following two Environment Variables in your Vercel project settings:
####Key: "SUPABASE_URL" | Value: https://"change this to ur project id".supabase.co
####Key: "SUPABASE_KEY" | Value: "paste ur publishable key here"}}  
