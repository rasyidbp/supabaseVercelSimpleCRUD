const express = require('express');
const cors = require('cors');
const { createClient } = require('@supabase/supabase-js');

const app = express();

// Middleware
app.use(cors());
app.use(express.json());

// Initialize Supabase (We will pass these as environment variables in Vercel)
const supabaseUrl = process.env.SUPABASE_URL;
const supabaseKey = process.env.SUPABASE_KEY;
const supabase = createClient(supabaseUrl, supabaseKey);

// Health Check Route
app.get('/api', (req, res) => {
  res.send('API is running!');
});

// CREATE: Add a new user
app.post('/api/users', async (req, res) => {
  const { name, email } = req.body;
  const { data, error } = await supabase
    .from('users')
    .insert([{ name, email }])
    .select(); // .select() ensures the newly created data is returned
    
  if (error) return res.status(400).json({ error: error.message });
  res.status(201).json(data);
});

// READ: Get all users
app.get('/api/users', async (req, res) => {
  const { data, error } = await supabase.from('users').select('*');
  
  if (error) return res.status(400).json({ error: error.message });
  res.status(200).json(data);
});

// UPDATE: Update a user by ID
app.put('/api/users/:id', async (req, res) => {
  const { id } = req.params;
  const { name, email } = req.body;
  const { data, error } = await supabase
    .from('users')
    .update({ name, email })
    .eq('id', id)
    .select();
    
  if (error) return res.status(400).json({ error: error.message });
  res.status(200).json(data);
});

// DELETE: Remove a user by ID
app.delete('/api/users/:id', async (req, res) => {
  const { id } = req.params;
  const { data, error } = await supabase
    .from('users')
    .delete()
    .eq('id', id)
    .select();
    
  if (error) return res.status(400).json({ error: error.message });
  res.status(200).json(data);
});

// Export the app so Vercel can turn it into a Serverless Function
module.exports = app;