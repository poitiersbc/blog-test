# yourword= raw_input("type your word \n")

def typeYourword():
  global yourword
  yourword= raw_input("type your word \n")
  while len(yourword)<4 or len(yourword)>4:
    yourword= raw_input("type your word again \n")
  else:
    print("Now your word : ",yourword," has the correct format")
    return yourword



#yourword='tata'


def monMot(tonmot):
    global var_glob
    var_glob=list(tonmot)
    return var_glob


def comptage(monmot):
    global var_comptage
    var_comptage = 0
    for cpte in range(0,(len(monmot))):
      print("this is your " + str(cpte+1) + " letter")
      for count in range(1,5):
        comptage_mot=cpte+1
        b = raw_input("Type your letter \n")
        if var_glob[cpte] == b and comptage_mot<4: 
          var_comptage+=1
          print ("yes")
          break
        elif var_glob[cpte] == b and comptage_mot==4:
          var_comptage+=1
          print ("You won. End of game")
          break
        else:
          if count == 4 and comptage_mot<4:
            print("this was your "+str(count)+ " last try for the "+str(comptage_mot)+" letter. let's go to the next letter")
          elif count == 4 and comptage_mot==4:
            print("this was your last try for the word. You guessed "+str(count)+ " letters. End of game.")
          else:
            print("wrong letter, try again" + " ,this was your " + str(count) + " try. Now your " +str(count+1) + " try")
    print(var_comptage)         

# ajouter un comptage de points
#             

typeYourword()
monMot(yourword) 
comptage(var_glob)

