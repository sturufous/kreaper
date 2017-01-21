# Knowledge Reaper

This goal of this application is to determine the political leaning of an artist from their song lyrics. This will be accomplished by performing a customized sentiment analysis of the Porter Stemmed lyrics contained in the Million Song Database (MSDB). 

The hard work will be generating a corpus of knowledge embodying the tone of left/right leaning writers. This will also need to take entity anlysis of political candidates into account, as well as the language used in connection with them.

The preliminary task is to create an interface that allows a user to explore the bands represented in the Musixmatch song lyrics repository. This provides visualizations of four levels of entities within the repository:

1. Artist
2. Album
3. Track
4. Lyrics

At each level in the hierarchy visual representations are provided of crowd sourced and algorithmically calculated statistics relating to the current entity. The home page presents the top ten highest trending artists from the Musixmatch API, including images when they are available. From this page bands can be searched using a simple string match and the user can browse the hierarchy of entities relating to that band.

## Tasks completed to date

Infrastructure has been developed including, but not limited to, the creation of:

1. A responsive, Bootstrap based page layout for each level of the hierarchy.
2. A repository-pattern based class for accessing the Musixmatch API.
3. A repository-pattern based class for accessing the FanTV Image API.
4. Artisan commands to allow the offline loading of images and database content.
5. Consolidated MSDB data in SQLite format.
6. Bootstrap and Fusion Charts based statistical views of the data.
7. A track-view page that facilitates the browsing of tracks in both the MSDB and those that are available in the Musixmatch API but not the MSDB.
8. A Wordcloud viewer that provides a semantic representation of Porter Stemmed lyrics from the MSDB or, if not available, lyrics retrieved from Musixmatch.

## Short term future goals

1. Create a repository for accessing the SQLite MSDB database.
2. Create methods within this repository that provide visual representations of the data relating to a band, album or track.
3. Analyze the MSDB to determine the quality and completeness of the data relating to a particular entity.
4. Determine a measure of reliability for the MSDB in the context of generalised sentiment analysis.

## Long term future goals

1. Create a corpus of politically oriented content.
2. Create word vector representations of the corpus using word2vec?
3. Train a neural net to perform sentiment analysis (Tensor Flow, Deep Mind?)

